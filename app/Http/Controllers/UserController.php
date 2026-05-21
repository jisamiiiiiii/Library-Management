<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');

        // Stats counts for the Tab UI (excluding current logged-in user)
        $allCount = User::where('id', '!=', auth()->id())->count();
        $studentCount = User::where('role', 'Student')->where('id', '!=', auth()->id())->count();
        $librarianCount = User::where('role', 'Librarian')->where('id', '!=', auth()->id())->count();

        // Combined logic: Search + Filter + Order + Pagination
        $users = User::where('id', '!=', auth()->id())
            ->when($role, function ($query, $role) {
                return $query->where('role', $role);
            })
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('department', 'like', "%{$search}%") // Added search by Dept
                      ->orWhere('role', 'like', "%{$search}%");
                });
            })
            ->orderBy('name', 'asc') // Better for directories than latest()
            ->paginate(15)           // Paginate for 100+ users
            ->withQueryString();     // Keeps your search/role filters in the pagination links

        return view('users.index', compact('users', 'allCount', 'studentCount', 'librarianCount'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role' => ['required', 'string', 'in:Student,Librarian,Admin'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'contact_number' => ['nullable', 'string', 'max:20'], // New field
            'department' => ['nullable', 'string', 'max:255'],     // New field
            'year_level' => ['nullable', 'string', 'max:50'],      // New field
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'contact_number' => $request->contact_number,
            'department' => $request->department,
            'year_level' => $request->year_level,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User account created successfully.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'string', 'in:Student,Librarian,Admin'],
            'contact_number' => ['nullable', 'string', 'max:20'],
            'department' => ['nullable', 'string', 'max:255'],
            'year_level' => ['nullable', 'string', 'max:50'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'contact_number' => $request->contact_number,
            'department' => $request->department,
            'year_level' => $request->year_level,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User profile updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot remove your own administrative account.');
        }

        $user->delete();
        
        return redirect()->route('users.index')
            ->with('success', 'User account removed successfully.');
    }
}