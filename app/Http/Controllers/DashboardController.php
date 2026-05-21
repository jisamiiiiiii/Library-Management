<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use App\Models\Borrow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. SHARED STATS (Admin sees global, Student sees personal)
        $stats = [
            'total_books'      => Book::count(),
            'pending_requests' => Borrow::where('status', 'pending')->count(),
        ];

        // Initialize variables to avoid "Undefined Variable" errors in Blade
        $student_stats = [];
        $my_active_loans = [];
        $my_activities = [];
        $analytics = [];
        $recent_activities = [];

        // 2. STUDENT SPECIFIC DATA
        if ($user->role === 'Student') {
            $student_stats = [
                'on_hand' => Borrow::where('user_id', $user->id)->where('status', 'borrowed')->count(),
                'lifetime' => Borrow::where('user_id', $user->id)->where('status', 'returned')->count(),
                'overdue' => Borrow::where('user_id', $user->id)
                                ->where('status', 'borrowed')
                                ->where('due_date', '<', now())
                                ->count(),
            ];

            // For the Active Loans Table
            $my_active_loans = Borrow::with('book')
                ->where('user_id', $user->id)
                ->where('status', 'borrowed')
                ->latest()
                ->get();

            // For the Activity Feed (Fixes your error)
            $my_activities = Borrow::with('book')
                ->where('user_id', $user->id)
                ->latest()
                ->take(10)
                ->get();
        }

        // 3. ADMIN/LIBRARIAN ANALYTICS
        if (in_array($user->role, ['Admin', 'Librarian'])) {
            // Trend Logic
            $rawTrend = Borrow::select(
                    DB::raw('COUNT(*) as total'), 
                    DB::raw("DATE_FORMAT(created_at, '%b') as month")
                )
                ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
                ->groupBy('month')
                ->get()
                ->pluck('total', 'month')
                ->toArray();

            $monthlyTrend = [];
            for ($i = 5; $i >= 0; $i--) {
                $monthName = now()->subMonths($i)->format('M');
                $monthlyTrend[$monthName] = $rawTrend[$monthName] ?? 0;
            }

            $analytics = [
                'overdue_count'  => Borrow::where('status', 'borrowed')->where('due_date', '<', now())->count(),
                'monthly_trend'  => $monthlyTrend,
                'top_borrowers'  => Borrow::select('user_id', DB::raw('count(*) as total'))
                                    ->with('user')
                                    ->groupBy('user_id')
                                    ->orderBy('total', 'desc')
                                    ->take(5)
                                    ->get(),
                'currently_out'  => Borrow::with(['user', 'book'])
                                    ->where('status', 'borrowed')
                                    ->latest('created_at')
                                    ->get(),
                'recent_returns' => Borrow::with(['user', 'book'])
                                    ->where('status', 'returned')
                                    ->whereNotNull('returned_at')
                                    ->latest('returned_at')
                                    ->take(5)
                                    ->get(),
            ];

            // General System Activity for Admin Feed
            $recent_activities = Borrow::with(['user', 'book'])
                ->latest()
                ->take(10)
                ->get();
        }

        return view('dashboard', compact(
            'stats', 
            'student_stats', 
            'my_active_loans', 
            'my_activities', 
            'analytics', 
            'recent_activities'
        ));
    }
}