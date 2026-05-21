<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight tracking-tight">
            {{ __('Book Details') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Navigation Row --}}
            <div class="flex justify-between items-center mb-6">
                <a href="{{ route('books.index') }}" class="inline-flex items-center text-[10px] font-black uppercase tracking-[0.3em] text-indigo-600 hover:translate-x-[-5px] transition-transform duration-300">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                    Return to Catalog
                </a>

                {{-- Admin Quick Actions --}}
                @if(in_array(Auth::user()->role, ['Admin', 'Librarian']))
                    <div class="flex space-x-2">
                        <a href="{{ route('books.edit', $book->id) }}" class="px-4 py-2 bg-white border border-gray-200 text-indigo-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-50 transition-all shadow-sm">
                            Edit Book
                        </a>
                        @if(Auth::user()->role === 'Admin')
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Delete this record permanently?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-50 text-red-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all shadow-sm">
                                    Remove
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>

            <div class="bg-white/60 backdrop-blur-2xl border border-white shadow-[0_32px_64px_-15px_rgba(0,0,0,0.1)] rounded-[3rem] overflow-hidden">
                <div class="md:flex">
                    
                    {{-- Left Side: Image/Visual --}}
                    <div class="md:w-1/3 bg-gray-200/30 flex items-center justify-center p-10 border-r border-white/20">
                        @if($book->cover_image)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="rounded-[2rem] shadow-2xl w-full object-cover transform group-hover:scale-[1.02] transition-transform duration-500">
                                <div class="absolute inset-0 rounded-[2rem] shadow-[inset_0_0_40px_rgba(0,0,0,0.1)]"></div>
                            </div>
                        @else
                            <div class="text-center p-12 bg-white/40 rounded-[2rem] border-2 border-dashed border-gray-300">
                                <svg class="mx-auto h-20 w-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="mt-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Visual Unavailable</p>
                            </div>
                        @endif
                    </div>

                    {{-- Right Side: Details --}}
                    <div class="md:w-2/3 p-12">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex gap-2">
                                    <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-[0.2em] bg-indigo-100 text-indigo-700 border border-indigo-200">
                                        {{ $book->category->category_name ?? 'General' }}
                                    </span>
                                    @if($book->department)
                                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-[0.2em] bg-blue-100 text-blue-700 border border-blue-200">
                                            {{ $book->department }}
                                        </span>
                                    @endif
                                </div>
                                <h1 class="text-5xl font-black text-gray-900 mt-4 tracking-tighter leading-tight">{{ $book->title }}</h1>
                                <p class="text-xl text-gray-500 mt-2 font-medium">By <span class="text-gray-800 font-bold underline decoration-indigo-200 decoration-4 underline-offset-4">{{ $book->author }}</span></p>
                            </div>
                            
                            <div class="ml-4">
                                @php
                                    $statusClasses = [
                                        'available' => 'bg-emerald-100 text-emerald-700 border-emerald-200 shadow-emerald-100',
                                        'borrowed' => 'bg-amber-100 text-amber-700 border-amber-200 shadow-amber-100',
                                        'lost' => 'bg-red-100 text-red-700 border-red-200 shadow-red-100',
                                    ][$book->status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="px-5 py-2.5 rounded-2xl border-2 font-black text-xs uppercase tracking-widest shadow-lg {{ $statusClasses }}">
                                    {{ $book->status }}
                                </span>
                            </div>
                        </div>

                        {{-- Metadata Grid --}}
                        <div class="mt-10 grid grid-cols-2 gap-6">
                            <div class="bg-white/80 p-6 rounded-3xl shadow-sm border border-white hover:shadow-md transition-shadow">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Standard Code (ISBN)</p>
                                <p class="text-gray-900 font-mono text-xl font-bold tracking-tight">{{ $book->isbn }}</p>
                            </div>
                            <div class="bg-white/80 p-6 rounded-3xl shadow-sm border border-white hover:shadow-md transition-shadow">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Placement In Library</p>
                                <p class="text-gray-900 font-bold text-xl tracking-tight">{{ $book->location ?? 'General Stacks' }}</p>
                            </div>
                        </div>

                        {{-- Description Section --}}
                        <div class="mt-10">
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em] mb-4">Summary & Abstract</h3>
                            <div class="bg-white/40 p-8 rounded-[2rem] border border-white/60">
                                <p class="text-gray-600 leading-relaxed font-medium text-lg italic">
                                    "{{ $book->description ?? 'No summary available for this specific academic resource. Please refer to the librarian for more details regarding the contents.' }}"
                                </p>
                            </div>
                        </div>

                        {{-- Action Footer --}}
                        <div class="mt-12 pt-8 border-t border-gray-100 flex items-center justify-between">
                            <div class="flex items-center space-x-6">
                                @if(Auth::user()->role === 'Student')
                                    @php
                                        $borrowCount = Auth::user()->borrows()->whereIn('status', ['pending', 'borrowed'])->count();
                                    @endphp

                                    @if($book->status === 'available')
                                        @if($borrowCount < 4)
                                            <form action="{{ route('borrows.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs uppercase tracking-[0.2em] py-5 px-12 rounded-2xl shadow-[0_20px_40px_-10px_rgba(79,70,229,0.4)] transition-all transform hover:scale-105 active:scale-95">
                                                    Authorize Borrowing
                                                </button>
                                            </form>
                                        @else
                                            <div class="bg-red-50 border border-red-100 p-4 rounded-2xl">
                                                <p class="text-[10px] font-black text-red-600 uppercase tracking-widest">Limit Reached</p>
                                                <p class="text-xs text-red-500 font-bold">You currently have {{ $borrowCount }} active requests.</p>
                                            </div>
                                        @endif
                                    @else
                                        <button disabled class="bg-gray-200 text-gray-400 font-black text-xs uppercase tracking-[0.2em] py-5 px-12 rounded-2xl cursor-not-allowed">
                                            Currently Unavailable
                                        </button>
                                    @endif
                                @else
                                    {{-- Admin View: Simply show status --}}
                                    <div class="bg-indigo-50 border border-indigo-100 p-4 rounded-2xl">
                                        <p class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">Management Mode</p>
                                        <p class="text-xs text-indigo-500 font-bold">Use the buttons above to modify this record.</p>
                                    </div>
                                @endif
                            </div>

                            <div class="text-right">
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Current Stock</p>
                                <p class="text-sm font-bold text-gray-700">{{ $book->quantity ?? '1' }} Units Remaining</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- NEW: Borrowing History Section --}}
                <div class="border-t border-gray-100 bg-gray-50/50">
                    <div class="px-12 py-8">
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em] mb-6">Circulation History</h3>
                        
                        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 text-[10px] font-black uppercase tracking-widest text-gray-400 border-b border-gray-200">
                                        <th class="px-6 py-4">Borrower Name</th>
                                        <th class="px-6 py-4">Date Borrowed</th>
                                        <th class="px-6 py-4">Date Returned</th>
                                        <th class="px-6 py-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($book->borrows as $borrow)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="h-7 w-7 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-[10px] mr-3">
                                                        {{ substr($borrow->user->name, 0, 1) }}
                                                    </div>
                                                    <span class="text-sm font-bold text-gray-700">{{ $borrow->user->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $borrow->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                @if($borrow->returned_at)
                                                    <span class="text-emerald-600 font-semibold">{{ $borrow->returned_at->format('M d, Y') }}</span>
                                                @else
                                                    <span class="text-gray-300 italic">Not yet returned</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-wider 
                                                    {{ $borrow->status == 'returned' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                                    {{ $borrow->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-12 text-center">
                                                <p class="text-sm text-gray-400 italic">No borrowing history available for this record.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- End History Section --}}

            </div>
        </div>
    </div>
</x-app-layout>