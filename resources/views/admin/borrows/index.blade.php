<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Manage Borrow Requests') }}
            </h2>
            <div class="text-sm text-gray-500 font-medium bg-white/50 px-4 py-1 rounded-full border border-white/80">
                Librarian Access: <span class="text-indigo-600 font-bold">{{ Auth::user()->name }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-[#f8faff] via-[#eef2ff] to-[#f0f4ff] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-white/60 backdrop-blur-md rounded-[2rem] p-7 border border-white/80 shadow-sm transition-all hover:shadow-md">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-amber-100/50 rounded-2xl">
                            <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pending</p>
                            <h3 class="text-3xl font-black text-gray-800">{{ $borrows->where('status', 'pending')->count() }}</h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white/60 backdrop-blur-md rounded-[2rem] p-7 border border-white/80 shadow-sm transition-all hover:shadow-md">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-blue-100/50 rounded-2xl">
                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Borrowed</p>
                            <h3 class="text-3xl font-black text-gray-800">{{ $borrows->where('status', 'borrowed')->count() }}</h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white/60 backdrop-blur-md rounded-[2rem] p-7 border border-white/80 shadow-sm transition-all hover:shadow-md">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-emerald-100/50 rounded-2xl">
                            <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Returned</p>
                            <h3 class="text-3xl font-black text-gray-800">{{ $borrows->where('status', 'returned')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-xl shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-[2.5rem] overflow-hidden border border-white">
                <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-white/30">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Borrow Requests</h3>
                        <p class="text-sm text-gray-500">Review and authorize book transactions</p>
                    </div>
                </div>

                <div class="overflow-x-auto p-6">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">
                                <th class="px-6 py-4">Borrower</th>
                                <th class="px-6 py-4">Book Reference</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($borrows as $borrow)
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="text-sm font-bold text-gray-900">{{ $borrow->user->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $borrow->user->email }}</div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm text-gray-700 font-medium">{{ $borrow->book->title }}</div>
                                    <div class="text-[10px] text-indigo-500 font-bold">ISBN: {{ $borrow->book->isbn ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @php
                                        $statusClass = [
                                            'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                            'borrowed' => 'bg-blue-100 text-blue-700 border-blue-200',
                                            'returned' => 'bg-emerald-100 text-emerald-700 border-emerald-200'
                                        ][$borrow->status] ?? 'bg-gray-100 text-gray-700';
                                    @endphp
                                    <span class="px-4 py-1 rounded-lg text-[10px] font-black uppercase border {{ $statusClass }}">
                                        {{ $borrow->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    @if($borrow->status === 'pending')
                                        <form action="{{ route('borrows.update', $borrow) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="px-6 py-2 bg-[#5d5bf4] text-white rounded-xl text-xs font-bold shadow-lg hover:bg-[#4a48d1] transition transform active:scale-95">
                                                Approve
                                            </button>
                                        </form>
                                    @elseif($borrow->status === 'borrowed')
                                        <form action="{{ route('borrows.return', $borrow) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="px-6 py-2 bg-[#5e92f3] text-white rounded-xl text-xs font-bold shadow-lg hover:bg-[#4a7dce] transition transform active:scale-95">
                                                Mark Return
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-300 italic font-medium">Logged</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center text-gray-400 italic">
                                    No transaction records found.
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