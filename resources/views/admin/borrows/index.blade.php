<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-2xl text-gray-800 tracking-tight">
                {{ __('Administrative Authority: Borrows') }}
            </h2>
            <div class="flex items-center space-x-3">
                <div class="text-right hidden sm:block">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Access Level</p>
                    <p class="text-sm font-bold text-indigo-600">Librarian Console</p>
                </div>
                <div class="h-10 w-10 rounded-2xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-200">
                    <span class="text-white font-black text-xs uppercase">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-[#f8faff] via-[#eef2ff] to-[#f0f4ff] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Administrative Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                {{-- Stat 1: Pending --}}
                <div class="bg-white/60 backdrop-blur-md rounded-[2.5rem] p-7 border border-white/80 shadow-sm transition-all hover:shadow-xl hover:translate-y-[-4px]">
                    <div class="flex items-center space-x-4">
                        <div class="p-4 bg-amber-100/50 rounded-2xl text-amber-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Queue Status</p>
                            <h3 class="text-3xl font-black text-gray-900 tracking-tighter">{{ $borrows->where('status', 'pending')->count() }} <span class="text-sm font-bold text-amber-500 uppercase">Pending</span></h3>
                        </div>
                    </div>
                </div>

                {{-- Stat 2: Monthly Velocity (NEW) --}}
                <div class="bg-white/60 backdrop-blur-md rounded-[2.5rem] p-7 border border-white/80 shadow-sm transition-all hover:shadow-xl hover:translate-y-[-4px]">
                    <div class="flex items-center space-x-4">
                        <div class="p-4 bg-purple-100/50 rounded-2xl text-purple-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Monthly Growth</p>
                            <h3 class="text-3xl font-black text-gray-900 tracking-tighter">
                                {{ $borrows->where('created_at', '>=', now()->startOfMonth())->count() }}
                                <span class="text-xs font-bold text-purple-500 uppercase tracking-tighter">This Month</span>
                            </h3>
                        </div>
                    </div>
                </div>

                {{-- Stat 3: Current Loans --}}
                <div class="bg-white/60 backdrop-blur-md rounded-[2.5rem] p-7 border border-white/80 shadow-sm transition-all hover:shadow-xl hover:translate-y-[-4px]">
                    <div class="flex items-center space-x-4">
                        <div class="p-4 bg-indigo-100/50 rounded-2xl text-indigo-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Current Loans</p>
                            <h3 class="text-3xl font-black text-gray-900 tracking-tighter">{{ $borrows->where('status', 'borrowed')->count() }} <span class="text-sm font-bold text-indigo-500 uppercase">Out</span></h3>
                        </div>
                    </div>
                </div>

                {{-- Stat 4: Closed --}}
                <div class="bg-white/60 backdrop-blur-md rounded-[2.5rem] p-7 border border-white/80 shadow-sm transition-all hover:shadow-xl hover:translate-y-[-4px]">
                    <div class="flex items-center space-x-4">
                        <div class="p-4 bg-emerald-100/50 rounded-2xl text-emerald-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Completed</p>
                            <h3 class="text-3xl font-black text-gray-900 tracking-tighter">{{ $borrows->where('status', 'returned')->count() }} <span class="text-sm font-bold text-emerald-500 uppercase">Closed</span></h3>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Management Table --}}
            <div class="bg-white/80 backdrop-blur-xl shadow-[0_20px_60px_rgba(0,0,0,0.04)] rounded-[3rem] overflow-hidden border border-white">
                <div class="p-10 border-b border-gray-50 flex flex-col md:flex-row justify-between items-center bg-white/30 gap-4">
                    <div>
                        <h3 class="text-2xl font-black text-gray-900 tracking-tight">Active Borrowing Logs</h3>
                        <p class="text-[11px] font-bold text-indigo-400 uppercase tracking-[0.2em] mt-1">Real-time Transaction tracking</p>
                    </div>
                    
                    {{-- Quick Filter/Search (NEW) --}}
                    <div class="relative w-full md:w-72">
                        <input type="text" placeholder="Search logs..." class="w-full bg-white/50 border-gray-100 rounded-2xl px-5 py-3 text-xs font-bold focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        <svg class="absolute right-4 top-3.5 h-4 w-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                </div>

                <div class="overflow-x-auto px-8 pb-8">
                    <table class="w-full text-left border-separate border-spacing-y-2">
                        <thead>
                            <tr class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                <th class="px-6 py-6">Identity</th>
                                <th class="px-6 py-6">Resource Details</th>
                                <th class="px-6 py-6 text-center">Transaction Timeline</th>
                                <th class="px-6 py-6 text-center">Status</th>
                                <th class="px-6 py-6 text-right">Control Authority</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50/50">
                            @forelse($borrows as $borrow)
                            <tr class="hover:bg-white transition-all group shadow-sm rounded-2xl overflow-hidden">
                                <td class="px-6 py-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="h-9 w-9 rounded-xl bg-indigo-50 flex items-center justify-center font-black text-indigo-400 text-xs uppercase border border-indigo-100">
                                            {{ substr($borrow->user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-black text-gray-900 leading-none mb-1">{{ $borrow->user->name }}</div>
                                            <div class="text-[10px] font-bold text-gray-400 tracking-tight">{{ $borrow->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="flex items-center space-x-4">
                                        <div class="h-16 w-12 flex-shrink-0 bg-gray-50 rounded-lg overflow-hidden shadow-sm border border-gray-100">
                                            @if($borrow->book->cover_image)
                                                <img src="{{ asset('storage/' . $borrow->book->cover_image) }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center bg-gray-50">
                                                    <svg class="h-5 w-5 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-900 font-black tracking-tighter leading-none mb-1">{{ Str::limit($borrow->book->title, 25) }}</div>
                                            <div class="text-[10px] text-indigo-500 font-black uppercase tracking-tighter">ID: {{ $borrow->book->isbn ?? $borrow->book->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-6">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <div class="flex items-center space-x-2">
                                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 shadow-[0_0_8px_rgba(129,140,248,0.6)]"></span>
                                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">In:</span>
                                            <span class="text-xs font-bold text-gray-700">{{ $borrow->created_at->format('d M Y') }}</span>
                                        </div>
                                        @if($borrow->status === 'returned')
                                        <div class="flex items-center space-x-2">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.6)]"></span>
                                            <span class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Out:</span>
                                            <span class="text-xs font-bold text-emerald-700">{{ $borrow->updated_at->format('d M Y') }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-6 text-center">
                                    @php
                                        $statusClass = [
                                            'pending' => 'bg-amber-100 text-amber-700 border-amber-200 shadow-amber-50',
                                            'borrowed' => 'bg-indigo-600 text-white border-indigo-700 shadow-indigo-100',
                                            'returned' => 'bg-emerald-100 text-emerald-700 border-emerald-200 shadow-emerald-50'
                                        ][$borrow->status] ?? 'bg-gray-100 text-gray-700';
                                    @endphp
                                    <span class="px-4 py-2 rounded-xl text-[9px] font-black uppercase border shadow-sm {{ $statusClass }} transition-all">
                                        {{ $borrow->status }}
                                    </span>
                                </td>

                                <td class="px-6 py-6 text-right">
                                    @if($borrow->status === 'pending')
                                        <form action="{{ route('borrows.update', $borrow) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="px-6 py-3 bg-gray-900 text-white rounded-2xl text-[9px] font-black uppercase tracking-widest shadow-xl hover:bg-indigo-600 transition-all transform hover:scale-105 active:scale-95">
                                                Approve Loan
                                            </button>
                                        </form>
                                    @elseif($borrow->status === 'borrowed')
                                        <form action="{{ route('borrows.return', $borrow) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="px-6 py-3 bg-white border-2 border-emerald-500 text-emerald-600 rounded-2xl text-[9px] font-black uppercase tracking-widest hover:bg-emerald-600 hover:text-white transition-all transform hover:scale-105 active:scale-95">
                                                Confirm Return
                                            </button>
                                        </form>
                                    @else
                                        <div class="inline-flex items-center px-4 py-2 bg-emerald-50 rounded-xl text-emerald-600 border border-emerald-100">
                                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                            <span class="text-[9px] font-black uppercase tracking-widest">Archived</span>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-24 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="p-8 bg-indigo-50 rounded-[2rem] mb-6">
                                            <svg class="h-12 w-12 text-indigo-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                        </div>
                                        <p class="text-[11px] font-black text-gray-300 uppercase tracking-[0.4em]">Vault Empty: No Transactions Found</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>