<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
            {{ __('Library Inventory') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-tr from-indigo-100 via-white to-blue-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                @if(session('success'))
                    <div 
                        x-data="{ show: true }" 
                        x-show="show" 
                        x-init="setTimeout(() => show = false, 5000)"
                        x-transition:leave="transition ease-in duration-500"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="relative overflow-hidden bg-emerald-500/20 backdrop-blur-xl border border-emerald-500/40 p-4 rounded-2xl flex items-center justify-between text-emerald-800 shadow-xl shadow-emerald-500/10"
                    >
                        <div class="flex items-center">
                            <div class="p-2 bg-emerald-500 rounded-xl mr-4 shadow-lg shadow-emerald-500/40">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <p class="font-black text-[10px] uppercase tracking-widest opacity-60 leading-none mb-1">System Message</p>
                                <p class="font-bold text-sm tracking-tight">{{ session('success') }}</p>
                            </div>
                        </div>
                        <button @click="show = false" class="p-2 hover:bg-emerald-500/20 rounded-xl transition-colors group">
                            <svg class="w-5 h-5 text-emerald-600 group-hover:text-emerald-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                        <div class="absolute bottom-0 left-0 h-1 bg-emerald-500/30 w-full">
                            <div x-init="$el.style.transition = 'width 5s linear'; $el.style.width = '0%'" class="h-full bg-emerald-500 w-full"></div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div 
                        x-data="{ show: true }" 
                        x-show="show" 
                        x-init="setTimeout(() => show = false, 7000)"
                        x-transition:leave="transition ease-in duration-500"
                        class="relative overflow-hidden bg-red-500/20 backdrop-blur-xl border border-red-500/40 p-4 rounded-2xl flex items-center justify-between text-red-800 shadow-xl shadow-red-500/10"
                    >
                        <div class="flex items-center">
                            <div class="p-2 bg-red-500 rounded-xl mr-4 shadow-lg shadow-red-500/40">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div>
                                <p class="font-black text-[10px] uppercase tracking-widest opacity-60 leading-none mb-1">Action Denied</p>
                                <p class="font-bold text-sm tracking-tight">{{ session('error') }}</p>
                            </div>
                        </div>
                        <button @click="show = false" class="p-2 hover:bg-red-500/20 rounded-xl transition-colors group">
                            <svg class="w-5 h-5 text-red-600 group-hover:text-red-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif
            </div>

            <div class="mb-8 px-2">
                <form action="{{ route('books.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                    <div class="relative flex-grow group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                            <svg class="w-5 h-5 text-indigo-500 group-focus-within:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Search by Title, Author, ISBN..." 
                            class="block w-full pl-12 pr-4 py-4 border border-white/40 rounded-2xl bg-white/60 backdrop-blur-md focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 text-gray-700 shadow-xl transition-all outline-none">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl shadow-lg transition-all transform hover:scale-105 active:scale-95">
                            Search
                        </button>
                        @if(request('search'))
                            <a href="{{ route('books.index') }}" class="px-6 py-4 bg-white/80 hover:bg-white text-gray-600 font-bold rounded-2xl shadow-md border border-gray-200 transition-all text-center">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="bg-white/40 backdrop-blur-lg border border-white/40 shadow-2xl rounded-[2.5rem] overflow-hidden p-4 md:p-8">
                
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 px-2">
                    <div>
                        <h3 class="text-3xl font-black text-gray-900 tracking-tighter">Books Collection</h3>
                        <p class="text-sm font-medium text-gray-500">
                            @if(request('search'))
                                Found {{ $books->count() }} results for "<span class="text-indigo-600 font-bold">{{ request('search') }}</span>"
                            @else
                                Managing {{ $books->count() }} books in total
                            @endif
                        </p>
                    </div>
                    
                    @auth
                        @if(in_array(Auth::user()->role, ['Admin', 'Librarian'])) 
                            <a href="{{ route('books.create') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg transition-all transform hover:scale-105">
                                + Add New Book
                            </a>
                        @endif
                    @endauth
                </div>

                <div class="overflow-x-auto rounded-[2rem] border border-white/60 bg-white/20">
                    <table class="min-w-full divide-y divide-gray-200/50">
                        <thead>
                            <tr class="bg-white/50 text-left">
                                <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">ISBN</th>
                                <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Book Title</th>
                                <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Category</th>
                                <th class="px-6 py-5 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Status</th>
                                @if(Auth::user()->role !== 'Student')
                                    <th class="px-6 py-5 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100/50">
                            @forelse ($books as $book)
                                <tr class="hover:bg-white/60 transition-all group">
                                    <td class="px-6 py-4 text-sm font-mono text-gray-500 uppercase">{{ $book->isbn }}</td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $book->title }}</div>
                                        <div class="text-xs text-gray-500 font-medium italic">{{ $book->author }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-[10px] font-black uppercase border border-indigo-100">
                                            {{ $book->category->category_name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $book->status == 'available' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-red-100 text-red-700 border border-red-200' }}">
                                            {{ $book->status }}
                                        </span>
                                    </td>
                                    @if(Auth::user()->role !== 'Student')
                                        <td class="px-6 py-4 text-center"> 
                                            <div class="flex justify-center items-center space-x-2">
                                                @if(in_array(Auth::user()->role, ['Admin', 'Librarian']))
                                                    <a href="{{ route('books.edit', $book->id) }}" class="p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                    </a>
                                                    @if(Auth::user()->role === 'Admin')
                                                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all shadow-sm" onclick="return confirm('Delete this book permanently?')">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ Auth::user()->role === 'Student' ? 4 : 5 }}" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="p-4 bg-gray-50 rounded-full mb-4">
                                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.247 18.477 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            </div>
                                            <p class="text-gray-400 font-medium">No matches found.</p>
                                            <a href="{{ route('books.index') }}" class="text-indigo-600 font-bold text-sm mt-2 hover:underline">Show all books</a>
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