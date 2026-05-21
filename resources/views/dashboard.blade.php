<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight tracking-tight">
            {{ Auth::user()->role === 'Student' ? __('My Student Dashboard') : __('Library Command Center') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-50 via-indigo-50 to-blue-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
        
            {{-- Welcome Header --}}
            <div class="mb-10 px-2 flex justify-between items-end">
                <div>
                    <h1 class="text-4xl font-black text-gray-900 tracking-tighter">
                        Welcome back, <span class="text-indigo-600">{{ Auth::user()->name }}!</span>
                    </h1>
                    <p class="text-gray-500 font-medium mt-1">
                        {{ Auth::user()->role === 'Student' ? "Track your reading journey and due dates." : "Real-time library analytics and oversight." }}
                    </p>
                </div>
                <div class="hidden md:block text-right">
                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Current Session</p>
                    <p class="text-sm font-bold text-gray-800">{{ now()->format('M d, Y') }}</p>
                </div>
            </div>

            {{-- Stats Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if(Auth::user()->role === 'Student')
                    {{-- Student Stat 1: Books on Hand --}}
                    <div class="bg-white/80 backdrop-blur-xl border border-white p-8 rounded-[2rem] shadow-xl shadow-blue-500/5 hover:scale-[1.02] transition-all duration-300 group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Books on Hand</p>
                                <h4 class="text-5xl font-black text-blue-600 tracking-tighter">
                                    {{ $student_stats['on_hand'] }}
                                </h4>
                            </div>
                            <div class="p-4 bg-blue-500/10 rounded-2xl group-hover:rotate-6 transition-transform">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.247 18.477 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Student Stat 2: Lifetime --}}
                    <div class="bg-white/80 backdrop-blur-xl border border-white p-8 rounded-[2rem] shadow-xl shadow-emerald-500/5 hover:scale-[1.02] transition-all duration-300 group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-black text-emerald-600/60 uppercase tracking-widest mb-1">Books Finished</p>
                                <h4 class="text-5xl font-black text-emerald-600 tracking-tighter">
                                    {{ $student_stats['lifetime'] }}
                                </h4>
                            </div>
                            <div class="p-4 bg-emerald-500/10 rounded-2xl group-hover:rotate-6 transition-transform">
                                <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Student Stat 3: Overdue --}}
                    <div class="bg-white/80 backdrop-blur-xl border border-white p-8 rounded-[2rem] shadow-xl shadow-red-500/5 hover:scale-[1.02] transition-all duration-300 group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-black text-red-600/60 uppercase tracking-widest mb-1">My Overdue</p>
                                <h4 class="text-5xl font-black text-red-600 tracking-tighter">{{ $student_stats['overdue'] }}</h4>
                            </div>
                            <div class="p-4 bg-red-500/10 rounded-2xl {{ $student_stats['overdue'] > 0 ? 'animate-pulse' : '' }}">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- ADMIN STATS --}}
                    <div class="bg-white/80 backdrop-blur-xl border border-white p-8 rounded-[2rem] shadow-xl shadow-indigo-500/5 hover:scale-[1.02] transition-all duration-300 group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Global Inventory</p>
                                <h4 class="text-5xl font-black text-indigo-600 tracking-tighter">{{ $stats['total_books'] }}</h4>
                            </div>
                            <div class="p-4 bg-indigo-500/10 rounded-2xl group-hover:rotate-6 transition-transform">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white/80 backdrop-blur-xl border border-white p-8 rounded-[2rem] shadow-xl shadow-amber-500/5 hover:scale-[1.02] transition-all duration-300 group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-black text-amber-600/60 uppercase tracking-widest mb-1">Pending Tasks</p>
                                <h4 class="text-5xl font-black text-amber-600 tracking-tighter">{{ $stats['pending_requests'] }}</h4>
                            </div>
                            <div class="p-4 bg-amber-500/10 rounded-2xl relative">
                                <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @if($stats['pending_requests'] > 0)
                                    <div class="absolute top-2 right-2 h-3 w-3 bg-red-500 rounded-full animate-ping"></div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="bg-white/80 backdrop-blur-xl border border-white p-8 rounded-[2rem] shadow-xl shadow-red-500/5 hover:scale-[1.02] transition-all duration-300 group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-black text-red-600/60 uppercase tracking-widest mb-1">Global Overdue</p>
                                <h4 class="text-5xl font-black text-red-600 tracking-tighter">{{ $analytics['overdue_count'] ?? 0 }}</h4>
                            </div>
                            <div class="p-4 bg-red-500/10 rounded-2xl group-hover:rotate-6">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- STUDENT VIEW: Personal History --}}
            @if(Auth::user()->role === 'Student')
                <div class="mt-12 bg-white/80 backdrop-blur-xl border border-white rounded-[2rem] shadow-xl overflow-hidden">
                    <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-xl font-black text-gray-800 tracking-tight">Recent Activity Log</h3>
                        <span class="text-xs font-black bg-blue-100 text-blue-600 px-4 py-1.5 rounded-full uppercase tracking-widest">Live Updates</span>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($my_activities as $activity)
                                <div class="flex items-center p-5 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-all group">
                                    <div class="w-12 h-16 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-xl mr-5 flex-shrink-0 flex items-center justify-center text-white shadow-lg">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"></path></svg>
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="font-bold text-gray-900 leading-tight group-hover:text-indigo-600 transition-colors">{{ $activity->book->title }}</h5>
                                        <div class="flex items-center mt-2">
                                            <span class="text-[10px] font-black uppercase tracking-widest px-2 py-0.5 rounded-md mr-2
                                                {{ $activity->status === 'borrowed' ? 'bg-blue-100 text-blue-600' : ($activity->status === 'returned' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600') }}">
                                                {{ $activity->status }}
                                            </span>
                                            @if($activity->status === 'borrowed' && $activity->due_date && $activity->due_date->isPast())
                                                <span class="text-red-500 font-black text-[10px] uppercase animate-pulse">● Overdue</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right ml-4">
                                        <p class="text-[10px] text-gray-400 font-black uppercase tracking-tighter">
                                            {{ $activity->status === 'returned' ? 'Back' : 'Due' }}
                                        </p>
                                        <p class="text-xs font-bold text-gray-700">
                                            {{ ($activity->status === 'returned' ? $activity->returned_at : $activity->due_date)?->format('M d') ?? '---' }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-2 py-12 text-center">
                                    <p class="text-gray-400 text-sm italic">You haven't borrowed any books yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif

            {{-- ADMIN ANALYTICS --}}
            @if(Auth::user()->role !== 'Student' && !empty($analytics))
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-12">
                    {{-- 1. Monthly Bar Chart --}}
                    <div class="bg-white/80 backdrop-blur-xl border border-white p-8 rounded-[2rem] shadow-xl shadow-indigo-500/5">
                        <div class="flex justify-between items-center mb-8">
                            <h3 class="text-xl font-black text-gray-800 tracking-tight">Monthly Borrowing Trends</h3>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Last 6 Months</p>
                        </div>
                        <div class="flex items-end justify-between h-56 gap-3 px-2">
                            @foreach($analytics['monthly_trend'] as $month => $count)
                                @php $height = $count > 0 ? min(($count / 20) * 100, 100) : 4; @endphp
                                <div class="flex-1 flex flex-col items-center group relative">
                                    <div class="absolute -top-10 opacity-0 group-hover:opacity-100 transition-all bg-gray-900 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg shadow-xl">
                                        {{ $count }} Borrowed
                                    </div>
                                    <div style="height: {{ $height }}%" class="w-full max-w-[40px] bg-gradient-to-t from-indigo-600 via-indigo-500 to-indigo-400 rounded-t-2xl transition-all duration-500 group-hover:brightness-110 shadow-lg shadow-indigo-200"></div>
                                    <span class="text-[10px] font-black text-gray-400 mt-4 uppercase tracking-tighter">{{ $month }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- 2. Leaderboard --}}
                    <div class="bg-white/80 backdrop-blur-xl border border-white p-8 rounded-[2rem] shadow-xl shadow-indigo-500/5">
                        <div class="flex justify-between items-center mb-8">
                            <h3 class="text-xl font-black text-gray-800 tracking-tight">Top Readers</h3>
                            
                        </div>
                        <div class="space-y-4">
                            @foreach($analytics['top_borrowers'] as $index => $data)
                                <div class="flex items-center p-4 rounded-2xl hover:bg-indigo-50/50 transition-all group border border-transparent hover:border-indigo-100">
                                    <div class="w-8 font-black {{ $index == 0 ? 'text-amber-500 text-lg' : 'text-gray-300' }}">
                                        {{ $index == 0 ? '𐃯' : '#'.($index + 1) }}
                                    </div>
                                    <div class="h-12 w-12 rounded-full bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white font-black shadow-inner mr-4">
                                        {{ substr($data->user->name, 0, 1) }}
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-black text-gray-800">{{ $data->user->name }}</p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Active Member</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-black text-indigo-600">{{ $data->total }}</p>
                                        <p class="text-[10px] text-gray-400 font-black uppercase">Books</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- 3. The Active Table --}}
                <div class="mt-8 bg-white/80 backdrop-blur-xl border border-white rounded-[2rem] shadow-xl overflow-hidden">
                    <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-xl font-black text-gray-800 tracking-tight">Live Loan Ledger</h3>
                        <div class="flex items-center gap-2 text-xs font-black text-blue-600 uppercase tracking-widest">
                            <span class="w-2 h-2 bg-blue-500 rounded-full animate-ping"></span> Syncing Live
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-separate border-spacing-0">
                            <thead>
                                <tr class="text-xs font-black text-gray-400 uppercase tracking-widest bg-gray-50/30">
                                    <th class="px-8 py-5 border-b border-gray-100">Borrower</th>
                                    <th class="px-8 py-5 border-b border-gray-100">Book Details</th>
                                    <th class="px-8 py-5 border-b border-gray-100 text-center">Condition</th>
                                    <th class="px-8 py-5 border-b border-gray-100 text-right">Timeline</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($analytics['currently_out'] as $loan)
                                    @php $isOverdue = $loan->due_date?->isPast(); @endphp
                                    <tr class="hover:bg-indigo-50/40 transition-all group">
                                        <td class="px-8 py-5">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center mr-4 group-hover:bg-indigo-100 transition-colors">
                                                    <span class="text-sm font-bold text-gray-600 group-hover:text-indigo-600">{{ substr($loan->user->name, 0, 1) }}</span>
                                                </div>
                                                <p class="text-sm font-bold text-gray-800">{{ $loan->user->name }}</p>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5 text-sm font-medium text-gray-600">
                                            {{ $loan->book->title }}
                                        </td>
                                        <td class="px-8 py-5 text-center">
                                            <span class="px-4 py-1 rounded-lg text-[10px] font-black uppercase shadow-sm
                                                {{ $isOverdue ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                                                {{ $isOverdue ? 'Overdue' : 'Active' }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-5 text-right">
                                            <p class="text-[10px] text-gray-400 font-black uppercase">Due Date</p>
                                            <p class="text-sm font-bold {{ $isOverdue ? 'text-red-600' : 'text-gray-800' }}">
                                                {{ $loan->due_date?->format('M d, Y') ?? 'N/A' }}
                                            </p>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-8 py-16 text-center text-gray-400 italic">No books are currently checked out.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- 4. Recent Returns Cards --}}
                <div class="mt-8">
                    <h3 class="text-xl font-black text-gray-800 px-2 mb-6 tracking-tight">Recently Returned</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @forelse($analytics['recent_returns'] as $return)
                            <div class="bg-white/60 backdrop-blur-sm border border-white p-5 rounded-3xl shadow-sm hover:shadow-md transition-all">
                                <p class="text-xs font-black text-gray-900 line-clamp-1 mb-1">{{ $return->book->title }}</p>
                                <p class="text-[10px] text-gray-500 font-bold uppercase mb-4 tracking-tighter">By {{ $return->user->name }}</p>
                                <div class="flex justify-between items-end">
                                    <span class="text-[10px] bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-md font-black uppercase tracking-widest">Restocked</span>
                                    <p class="text-[10px] text-gray-400 font-medium italic">{{ $return->returned_at?->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-4 bg-white/40 border border-dashed border-gray-300 rounded-3xl p-8 text-center text-gray-400 text-sm">
                                No recent returns to report.
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif

            {{-- ACTION CARDS --}}
            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8 pb-12">
                <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 p-10 rounded-[2.5rem] text-white shadow-2xl relative overflow-hidden group border border-white/10">
                    <div class="absolute -right-10 -bottom-10 opacity-10 group-hover:scale-110 transition-transform duration-700">
                        <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.247 18.477 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-3xl font-black tracking-tighter mb-2">Explore Library</h3>
                        <p class="mb-8 text-indigo-100 font-medium max-w-xs">Access our full catalog of thousands of books and resources.</p>
                        <a href="{{ route('books.index') }}" class="inline-flex items-center bg-white text-indigo-600 font-black px-8 py-4 rounded-2xl text-xs uppercase tracking-widest hover:bg-indigo-50 transition-colors shadow-lg">
                            Open Catalog →
                        </a>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 p-10 rounded-[2.5rem] text-white shadow-2xl relative overflow-hidden group border border-white/10">
                    <div class="absolute -right-10 -bottom-10 opacity-10 group-hover:scale-110 transition-transform duration-700">
                        <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-3xl font-black tracking-tighter mb-2">My Transactions</h3>
                        <p class="mb-8 text-slate-400 font-medium max-w-xs">Check your borrow history and manage pending requests.</p>
                        <a href="{{ route('borrows.index') }}" class="inline-flex items-center bg-white text-slate-900 font-black px-8 py-4 rounded-2xl text-xs uppercase tracking-widest hover:bg-slate-100 transition-colors shadow-lg">
                            Manage Logs →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>