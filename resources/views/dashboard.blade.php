<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
            {{ Auth::user()->role === 'Student' ? __('My Student Dashboard') : __('Library Overview') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-10 px-2">
                <h1 class="text-4xl font-black text-gray-900 tracking-tighter">
                    Welcome back, <span class="text-indigo-600">{{ Auth::user()->name }}!</span>
                </h1>
                <p class="text-gray-500 font-medium italic">
                    {{ Auth::user()->role === 'Student' ? "Here is your personal reading activity." : "Here is what's happening in the library today." }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
                
                @if(Auth::user()->role === 'Student')
                    <div class="bg-white/60 backdrop-blur-xl border border-white/40 p-6 rounded-[2.5rem] shadow-xl hover:scale-105 transition-all duration-300 group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Books on Hand</p>
                                <h4 class="text-4xl font-black text-blue-600 tracking-tighter">{{ \App\Models\Borrow::where('user_id', Auth::id())->where('status', 'borrowed')->count() }}</h4>
                            </div>
                            <div class="p-3 bg-blue-500/10 rounded-2xl group-hover:rotate-12 transition-transform">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.247 18.477 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white/60 backdrop-blur-xl border border-white/40 p-6 rounded-[2.5rem] shadow-xl hover:scale-105 transition-all duration-300 group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-black text-amber-600 uppercase tracking-[0.2em] mb-1">Waitlist</p>
                                <h4 class="text-4xl font-black text-amber-600 tracking-tighter">{{ \App\Models\Borrow::where('user_id', Auth::id())->where('status', 'pending')->count() }}</h4>
                            </div>
                            <div class="p-3 bg-amber-500/10 rounded-2xl group-hover:rotate-12 transition-transform">
                                <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white/60 backdrop-blur-xl border border-white/40 p-6 rounded-[2.5rem] shadow-xl hover:scale-105 transition-all duration-300 group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-black text-red-600 uppercase tracking-[0.2em] mb-1">Overdue</p>
                                <h4 class="text-4xl font-black text-red-600 tracking-tighter">{{ \App\Models\Borrow::where('user_id', Auth::id())->where('status', 'borrowed')->where('due_date', '<', now())->count() }}</h4>
                            </div>
                            <div class="p-3 bg-red-500/10 rounded-2xl group-hover:rotate-12 transition-transform">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white/60 backdrop-blur-xl border border-white/40 p-6 rounded-[2.5rem] shadow-xl hover:scale-105 transition-all duration-300 group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Total Inventory</p>
                                <h4 class="text-4xl font-black text-blue-600 tracking-tighter">{{ $stats['total_books'] }}</h4>
                            </div>
                            <div class="p-3 bg-blue-500/10 rounded-2xl group-hover:rotate-12 transition-transform">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.247 18.477 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white/60 backdrop-blur-xl border border-white/40 p-6 rounded-[2.5rem] shadow-xl hover:scale-105 transition-all duration-300 group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Members</p>
                                <h4 class="text-4xl font-black text-purple-600 tracking-tighter">{{ $stats['total_users'] }}</h4>
                            </div>
                            <div class="p-3 bg-purple-500/10 rounded-2xl group-hover:rotate-12 transition-transform">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white/60 backdrop-blur-xl border border-white/40 p-6 rounded-[2.5rem] shadow-xl hover:scale-105 transition-all duration-300 group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-black text-yellow-600 uppercase tracking-[0.2em] mb-1">Admin Alerts</p>
                                <h4 class="text-4xl font-black text-yellow-600 tracking-tighter">{{ $stats['pending_requests'] }}</h4>
                            </div>
                            <div class="p-3 bg-yellow-500/10 rounded-2xl group-hover:rotate-12 transition-transform">
                                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="bg-indigo-600 backdrop-blur-xl p-10 rounded-[2.5rem] text-white shadow-2xl relative overflow-hidden group border border-white/10">
                    <div class="relative z-10">
                        <h3 class="text-3xl font-black tracking-tighter mb-2">Book Collection</h3>
                        <p class="mb-8 opacity-80 font-medium">
                            {{ Auth::user()->role === 'Student' ? "Explore thousands of books and find your next read." : "Manage and organize the library inventory." }}
                        </p>
                        <a href="{{ route('books.index') }}" class="inline-flex items-center bg-white text-indigo-600 font-bold px-8 py-4 rounded-2xl hover:bg-indigo-50 transition-all shadow-lg active:scale-95 text-xs uppercase tracking-widest">
                            Browse Inventory
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                    <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
                </div>

                @if(Auth::user()->role === 'Student')
                    <div class="bg-emerald-600 backdrop-blur-xl p-10 rounded-[2.5rem] text-white shadow-2xl relative overflow-hidden group border border-white/10">
                        <div class="relative z-10">
                            <h3 class="text-3xl font-black tracking-tighter mb-2">My History</h3>
                            <p class="mb-8 opacity-80 font-medium">Check your return status and previous borrowing logs.</p>
                            <a href="{{ route('borrows.index') }}" class="inline-flex items-center bg-white text-emerald-600 font-bold px-8 py-4 rounded-2xl hover:bg-emerald-50 transition-all shadow-lg active:scale-95 text-xs uppercase tracking-widest">
                                View My Borrows
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </a>
                        </div>
                        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
                    </div>
                @else
                    <div class="bg-emerald-600 backdrop-blur-xl p-10 rounded-[2.5rem] text-white shadow-2xl relative overflow-hidden group border border-white/10">
                        <div class="relative z-10">
                            <h3 class="text-3xl font-black tracking-tighter mb-2">Request Ledger</h3>
                            <p class="mb-8 opacity-80 font-medium">Approve or finalize pending book requests from members.</p>
                            <a href="{{ route('admin.borrows.index') }}" class="inline-flex items-center bg-white text-emerald-600 font-bold px-8 py-4 rounded-2xl hover:bg-emerald-50 transition-all shadow-lg active:scale-95 text-xs uppercase tracking-widest">
                                Manage Requests
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </a>
                        </div>
                        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>