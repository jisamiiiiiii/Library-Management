<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-2xl text-gray-800 tracking-tight">
                {{ Auth::user()->role === 'Student' ? __('My Borrowing History') : __('Borrowing Management') }}
            </h2>
            
          
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-[#f8faff] via-[#f0f4ff] to-[#ffffff] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Statistics Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                {{-- Pending Card --}}
                <div class="bg-white/70 backdrop-blur-md border border-white shadow-xl rounded-[2.5rem] p-7 transition-all hover:translate-y-[-5px]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-amber-500 uppercase tracking-widest">
                                {{ Auth::user()->role === 'Student' ? 'My Pending' : 'Global Queue' }}
                            </p>
                            <h3 class="text-4xl font-black text-gray-900 mt-1">
                                {{ $borrows->where('status', 'pending')->count() }}
                            </h3>
                        </div>
                        <div class="p-4 bg-amber-50 rounded-2xl text-amber-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>
                </div>

                {{-- Active Card --}}
                <div class="bg-white/70 backdrop-blur-md border border-white shadow-xl rounded-[2.5rem] p-7 transition-all hover:translate-y-[-5px]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest">
                                {{ Auth::user()->role === 'Student' ? 'Current Books' : 'Total On Loan' }}
                            </p>
                            <h3 class="text-4xl font-black text-gray-900 mt-1">
                                {{ $borrows->where('status', 'borrowed')->count() }}
                                @if(Auth::user()->role === 'Student')
                                    <span class="text-sm font-bold text-gray-400">/ 4 Limit</span>
                                @endif
                            </h3>
                        </div>
                        <div class="p-4 bg-indigo-50 rounded-2xl text-indigo-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                    </div>
                </div>

                {{-- Returns Card --}}
                <div class="bg-white/70 backdrop-blur-md border border-white shadow-xl rounded-[2.5rem] p-7 transition-all hover:translate-y-[-5px]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">
                                {{ Auth::user()->role === 'Student' ? 'Total Returned' : 'Completed' }}
                            </p>
                            <h3 class="text-4xl font-black text-gray-900 mt-1">
                                {{ $borrows->where('status', 'returned')->count() }}
                            </h3>
                        </div>
                        <div class="p-4 bg-emerald-50 rounded-2xl text-emerald-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Table Container --}}
            <div class="bg-white/80 backdrop-blur-xl shadow-2xl rounded-[3rem] overflow-hidden border border-white">
                <div class="px-10 py-10 border-b border-gray-50 flex justify-between items-center bg-white/40">
                    <div>
                        <h3 class="font-black text-2xl text-gray-900 tracking-tight">
                            {{ Auth::user()->role === 'Student' ? 'My Library Activity' : 'Recent Transaction Logs' }}
                        </h3>
                        <p class="text-[11px] text-indigo-400 font-bold uppercase tracking-[0.2em] mt-1">Real-time status tracking</p>
                    </div>
                    <button onclick="window.location.reload()" class="bg-gray-900 text-white p-3 rounded-2xl transition-all hover:bg-indigo-600 shadow-lg active:scale-90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                </div>
                
                <div class="overflow-x-auto px-6 pb-6">
                    <table class="w-full text-left border-separate border-spacing-y-2">
                        <thead>
                            <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                <th class="px-6 py-4">@if(Auth::user()->role !== 'Student') Borrower @else Book Identity @endif</th>
                                @if(Auth::user()->role !== 'Student') <th class="px-6 py-4">Resource Details</th> @endif
                                <th class="px-6 py-4 text-center">Timeline</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                @if(Auth::user()->role !== 'Student') <th class="px-6 py-4 text-right">Administrative</th> @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50/50">
                            @forelse($borrows as $borrow)
                                <tr class="bg-white/50 hover:bg-white transition-all group rounded-2xl shadow-sm">
                                    {{-- Identity Column --}}
                                    <td class="px-6 py-6">
                                        @if(Auth::user()->role !== 'Student')
                                            <div class="flex items-center space-x-3">
                                                <div class="h-10 w-10 rounded-xl bg-gray-100 flex items-center justify-center font-black text-gray-400 text-xs">
                                                    {{ substr($borrow->user->name, 0, 2) }}
                                                </div>
                                                <div>
                                                    <div class="text-sm font-black text-gray-900">{{ $borrow->user->name }}</div>
                                                    <div class="text-[10px] text-gray-400 font-bold uppercase">{{ $borrow->user->email }}</div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex items-center space-x-4">
                                                <div class="h-16 w-12 bg-indigo-50 rounded-lg overflow-hidden shadow-sm flex-shrink-0">
                                                    @if($borrow->book->cover_image)
                                                        <img src="{{ asset('storage/' . $borrow->book->cover_image) }}" class="h-full w-full object-cover">
                                                    @else
                                                        <div class="h-full w-full flex items-center justify-center text-indigo-200">
                                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="text-sm font-black text-gray-900 leading-tight">{{ $borrow->book->title }}</div>
                                                    <div class="text-[10px] text-indigo-500 font-black tracking-widest mt-1 uppercase">#BK-{{ $borrow->book->id }}</div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>

                                    {{-- Admin Resource Details --}}
                                    @if(Auth::user()->role !== 'Student')
                                    <td class="px-6 py-6">
                                        <div class="text-sm text-gray-800 font-bold tracking-tight">{{ $borrow->book->title }}</div>
                                        <div class="text-[10px] text-indigo-500 font-black uppercase mt-0.5">REF: {{ $borrow->book->isbn ?? 'N/A' }}</div>
                                    </td>
                                    @endif

                                    {{-- Timeline (Updated with Expected Return) --}}
                                    <td class="px-6 py-6 text-center">
                                        <div class="flex flex-col items-center space-y-2">
                                            {{-- Request Date --}}
                                            <div class="flex flex-col items-center">
                                                <span class="text-[8px] font-black text-gray-400 uppercase tracking-widest">Out</span>
                                                <span class="text-xs font-bold text-gray-700">{{ $borrow->created_at->format('M d, Y') }}</span>
                                            </div>

                                            {{-- Due Date / Return Date Logic --}}
                                            @if($borrow->status !== 'pending' && $borrow->due_date)
                                                <div class="w-4 border-t border-gray-100"></div>
                                                @php
                                                    $dueDate = \Carbon\Carbon::parse($borrow->due_date);
                                                    $isOverdue = $dueDate->isPast() && $borrow->status === 'borrowed';
                                                @endphp
                                                <div class="flex flex-col items-center">
                                                    <span class="text-[8px] font-black {{ $isOverdue ? 'text-red-500' : 'text-indigo-400' }} uppercase tracking-widest">
                                                        {{ $borrow->status === 'returned' ? 'Returned' : 'Expected' }}
                                                    </span>
                                                    <span class="text-xs font-black {{ $isOverdue ? 'text-red-600' : 'text-gray-800' }}">
                                                        {{ $borrow->status === 'returned' ? $borrow->updated_at->format('M d, Y') : $dueDate->format('M d, Y') }}
                                                    </span>
                                                    @if($isOverdue)
                                                        <span class="text-[7px] bg-red-100 text-red-600 px-2 py-0.5 rounded-full font-black uppercase mt-1">Late</span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Status Badge --}}
                                    <td class="px-6 py-6 text-center">
                                        @php
                                            $statusBadge = [
                                                'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                                'borrowed' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                                                'returned' => 'bg-emerald-100 text-emerald-700 border-emerald-200'
                                            ][$borrow->status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                                        @endphp
                                        <span class="px-4 py-1.5 rounded-full text-[9px] font-black border uppercase shadow-sm {{ $statusBadge }}">
                                            {{ $borrow->status }}
                                        </span>
                                    </td>

                                    {{-- Action Buttons (Staff Only) --}}
                                    @if(Auth::user()->role !== 'Student')
                                        <td class="px-6 py-6 text-right">
                                            @if($borrow->status === 'pending')
                                                <form action="{{ route('borrows.update', $borrow) }}" method="POST" class="inline">
                                                    @csrf @method('PATCH')
                                                    <button class="bg-gray-900 text-white px-6 py-2.5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 transition shadow-lg active:scale-95">
                                                        Approve
                                                    </button>
                                                </form>
                                            @elseif($borrow->status === 'borrowed')
                                                <form action="{{ route('borrows.return', $borrow) }}" method="POST" class="inline">
                                                    @csrf @method('PATCH')
                                                    <button class="border-2 border-emerald-500 text-emerald-600 px-6 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-50 transition active:scale-95">
                                                        Mark Return
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-[10px] text-emerald-500 font-black uppercase tracking-widest opacity-50 flex items-center justify-end">
                                                    <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                                    Settled
                                                </span>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-10 py-32 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="bg-indigo-50 p-6 rounded-[2rem] mb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                            <p class="text-gray-400 font-black uppercase text-[11px] tracking-[0.3em]">No transaction logs found in system</p>
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