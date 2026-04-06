<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-2xl text-gray-800 tracking-tight">
                {{ Auth::user()->role === 'Student' ? __('My Borrowing History') : __('Borrowing Management') }}
            </h2>
            
            @if(Auth::user()->role !== 'Student')
                <div class="flex items-center space-x-2">
                    <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-black uppercase shadow-sm">
                        Staff Authority
                    </span>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-white/80 backdrop-blur-md border border-white shadow-xl rounded-2xl p-6">
                    <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest">
                        {{ Auth::user()->role === 'Student' ? 'My Pending Requests' : 'Global Pending Approval' }}
                    </p>
                    <h3 class="text-4xl font-bold text-gray-900 mt-1">{{ $borrows->where('status', 'pending')->count() }}</h3>
                </div>
                <div class="bg-white/80 backdrop-blur-md border border-white shadow-xl rounded-2xl p-6">
                    <p class="text-[10px] font-black text-blue-500 uppercase tracking-widest">
                        {{ Auth::user()->role === 'Student' ? 'Books I Have' : 'Total On Loan' }}
                    </p>
                    <h3 class="text-4xl font-bold text-gray-900 mt-1">{{ $borrows->where('status', 'borrowed')->count() }}</h3>
                </div>
                <div class="bg-white/80 backdrop-blur-md border border-white shadow-xl rounded-2xl p-6">
                    <p class="text-[10px] font-black text-green-500 uppercase tracking-widest">
                        {{ Auth::user()->role === 'Student' ? 'My Total Returns' : 'Global Returned' }}
                    </p>
                    <h3 class="text-4xl font-bold text-gray-900 mt-1">{{ $borrows->where('status', 'returned')->count() }}</h3>
                </div>
            </div>

            <div class="bg-white shadow-2xl rounded-3xl overflow-hidden border border-gray-100">
                <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800">
                        {{ Auth::user()->role === 'Student' ? 'My Transaction Logs' : 'Recent Request Logs' }}
                    </h3>
                    <button onclick="window.location.reload()" class="text-xs text-indigo-600 font-bold hover:underline">Refresh List</button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Borrower Details</th>
                                <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Book Title</th>
                                <th class="px-8 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                                
                                {{-- Hide Action Header from Students --}}
                                @if(Auth::user()->role !== 'Student')
                                    <th class="px-8 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($borrows as $borrow)
                                <tr class="hover:bg-indigo-50/30 transition-all duration-200">
                                    <td class="px-8 py-5">
                                        <div class="text-sm font-bold text-gray-900">{{ $borrow->user->name }}</div>
                                        <div class="text-[11px] text-gray-400">{{ $borrow->user->email }}</div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="text-sm text-gray-700 font-medium">{{ $borrow->book->title }}</div>
                                        <div class="text-[10px] text-indigo-400 font-bold">Ref: #BK-{{ $borrow->book->id }}</div>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        @if($borrow->status === 'pending')
                                            <span class="inline-block px-3 py-1 rounded-full text-[10px] font-black bg-yellow-100 text-yellow-700 uppercase">Pending</span>
                                        @elseif($borrow->status === 'borrowed')
                                            <span class="inline-block px-3 py-1 rounded-full text-[10px] font-black bg-blue-100 text-blue-700 uppercase">Borrowed</span>
                                        @else
                                            <span class="inline-block px-3 py-1 rounded-full text-[10px] font-black bg-green-100 text-green-700 uppercase">Returned</span>
                                        @endif
                                    </td>

                                    {{-- Hide Action Body from Students --}}
                                    @if(Auth::user()->role !== 'Student')
                                        <td class="px-8 py-5 text-right">
                                            @if($borrow->status === 'pending')
                                                <form action="{{ route('borrows.update', $borrow) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <button class="bg-gray-900 text-white px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-tighter hover:bg-indigo-600 transition shadow-lg">Approve</button>
                                                </form>
                                            @elseif($borrow->status === 'borrowed')
                                                <form action="{{ route('borrows.return', $borrow) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <button class="border-2 border-red-500 text-red-500 px-5 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-tighter hover:bg-red-50 transition">Mark Returned</button>
                                                </form>
                                            @else
                                                <span class="text-[10px] text-gray-300 font-bold uppercase tracking-widest">Completed</span>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ Auth::user()->role === 'Student' ? 3 : 4 }}" class="px-8 py-20 text-center">
                                        <p class="text-gray-400 italic text-sm">No records found in the archive.</p>
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