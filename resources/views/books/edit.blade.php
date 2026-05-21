<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-indigo-950 leading-tight tracking-tight">
            {{ __('Update Book Information') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- 1. ERROR TRAPPING BLOCK --}}
            {{-- This will show you EXACTLY why the save isn't proceeding (e.g. ISBN taken, field missing) --}}
            @if ($errors->any())
                <div class="mb-6 p-6 rounded-[2rem] bg-rose-50 border-2 border-rose-100 shadow-sm animate-pulse">
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-rose-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-rose-800 font-black uppercase tracking-widest text-sm">Action Required: Form Errors</h3>
                    </div>
                    <ul class="list-disc list-inside text-rose-700 font-bold text-sm ml-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- 2. ALPINE.JS DIRTY CHECKING --}}
            <div class="bg-white border border-indigo-100 shadow-2xl shadow-indigo-100/50 rounded-[2.5rem] p-8 md:p-12"
                 x-data="{ 
                    isDirty: false, 
                    checkChanges(e) {
                        if (!this.isDirty) {
                            e.preventDefault();
                            alert('No modifications detected. Please update at least one field before saving.');
                        }
                    }
                 }"
                 @input="isDirty = true"
                 @change="isDirty = true">
                
                {{-- Header Section --}}
                <div class="flex items-center justify-between mb-10 border-b border-slate-100 pb-8">
                    <div>
                        <h3 class="text-3xl font-black text-slate-900 uppercase tracking-tighter">Edit Repository</h3>
                        <p class="text-indigo-700 font-bold text-lg mt-1 italic">"{{ $book->title }}"</p>
                    </div>
                    <div class="hidden sm:flex h-20 w-20 bg-indigo-900 rounded-3xl items-center justify-center shadow-2xl shadow-indigo-200">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>

                <form action="{{ route('books.update', $book->id) }}" 
                      method="POST" 
                      enctype="multipart/form-data" 
                      class="space-y-8"
                      @submit="checkChanges($event)">
                    
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10">
                        
                        {{-- Book Title --}}
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-black text-slate-800 uppercase tracking-widest mb-3 ml-1">Book Title</label>
                            <input type="text" name="title" value="{{ old('title', $book->title) }}" required 
                                class="w-full rounded-2xl border-2 border-slate-200 bg-white text-slate-900 font-semibold focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all py-4 px-6 text-lg shadow-sm">
                        </div>

                        {{-- Author --}}
                        <div>
                            <label class="block text-sm font-black text-slate-800 uppercase tracking-widest mb-3 ml-1">Author / Creator</label>
                            <input type="text" name="author" value="{{ old('author', $book->author) }}" required 
                                class="w-full rounded-2xl border-2 border-slate-200 bg-white text-slate-900 font-semibold focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all py-4 px-6 shadow-sm">
                        </div>

                        {{-- ISBN --}}
                        <div>
                            <label class="block text-sm font-black text-slate-800 uppercase tracking-widest mb-3 ml-1">ISBN Number</label>
                            <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}" required 
                                class="w-full rounded-2xl border-2 border-slate-200 bg-white text-slate-900 font-semibold focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all py-4 px-6 shadow-sm">
                        </div>

                        {{-- Academic Category --}}
                        <div>
    <label class="block text-sm font-black text-slate-800 uppercase tracking-widest mb-3 ml-1">Academic Category</label>
    <select name="category_id" required 
        class="w-full rounded-2xl border-2 border-slate-200 bg-white text-slate-900 font-bold focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all py-4 px-6 shadow-sm appearance-none">
        
        <option value="" disabled>Select a Category</option>
        
        @foreach($categories as $category)
            <option value="{{ $category->id }}" 
                {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>

                        {{-- University Department --}}
                        <div>
                            <label class="block text-sm font-black text-slate-800 uppercase tracking-widest mb-3 ml-1">University Department</label>
                            <select name="department" required class="w-full rounded-2xl border-2 border-slate-200 bg-white text-slate-900 font-bold focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all py-4 px-6 shadow-sm appearance-none">
                                <option value="College of Computer Computing" {{ old('department', $book->department) == 'College of Computer Computing' ? 'selected' : '' }}>College of Computer Computing</option>
                                <option value="College of Engineering" {{ old('department', $book->department) == 'College of Engineering' ? 'selected' : '' }}>College of Engineering</option>
                                <option value="College of Nursing" {{ old('department', $book->department) == 'College of Nursing' ? 'selected' : '' }}>College of Nursing</option>
                                <option value="College of Education" {{ old('department', $book->department) == 'College of Education' ? 'selected' : '' }}>College of Education</option>
                                <option value="College of Business" {{ old('department', $book->department) == 'College of Business' ? 'selected' : '' }}>College of Business</option>
                            </select>
                        </div>

                        {{-- Physical Location --}}
                        <div>
                            <label class="block text-sm font-black text-slate-800 uppercase tracking-widest mb-3 ml-1">Physical Location (Shelf)</label>
                            <input type="text" name="location" value="{{ old('location', $book->location) }}" placeholder="e.g. Shelf A-12" required 
                                class="w-full rounded-2xl border-2 border-slate-200 bg-white text-slate-900 font-semibold focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all py-4 px-6 shadow-sm">
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="block text-sm font-black text-slate-800 uppercase tracking-widest mb-3 ml-1">Current Status</label>
                            <select name="status" class="w-full rounded-2xl border-2 border-slate-200 bg-white text-slate-900 font-bold focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all py-4 px-6 shadow-sm appearance-none">
                                <option value="available" {{ old('status', $book->status) == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="borrowed" {{ old('status', $book->status) == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                                <option value="lost" {{ old('status', $book->status) == 'lost' ? 'selected' : '' }}>Lost</option>
                            </select>
                        </div>

                        {{-- Summary --}}
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-black text-slate-800 uppercase tracking-widest mb-3 ml-1">Book Summary / Content Abstract</label>
                            <textarea name="summary" rows="5" class="w-full rounded-2xl border-2 border-slate-200 bg-white text-slate-900 font-medium focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all py-4 px-6 shadow-sm resize-none">{{ old('summary', $book->summary) }}</textarea>
                        </div>

                        {{-- Book Cover Image --}}
                        <div class="col-span-1 md:col-span-2 bg-slate-50 p-8 rounded-[2rem] border-2 border-dashed border-slate-200 flex flex-col md:flex-row items-center gap-8">
                            <div class="flex-shrink-0">
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-4 text-center md:text-left">Current Cover</label>
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" class="h-40 w-28 object-cover rounded-xl shadow-2xl border-4 border-white">
                                @else
                                    <div class="h-40 w-28 bg-slate-200 rounded-xl flex items-center justify-center text-slate-400 font-bold text-xs uppercase">No Image</div>
                                @endif
                            </div>
                            <div class="flex-grow w-full">
                                <label class="block text-sm font-black text-indigo-900 uppercase tracking-widest mb-3">Upload New Cover</label>
                                <input type="file" name="cover_image" @change="isDirty = true" class="block w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-indigo-900 file:text-white hover:file:bg-indigo-800 cursor-pointer transition-all">
                                <p class="mt-3 text-xs text-slate-400 font-bold uppercase tracking-tight italic">* Recommended size: 400x600px (JPG/PNG)</p>
                            </div>
                        </div>

                    </div>

                    {{-- Bottom Action Bar --}}
                    <div class="mt-12 flex flex-col sm:flex-row items-center justify-end gap-6 border-t border-slate-100 pt-10">
                        <a href="{{ route('books.index') }}" class="text-sm font-black text-slate-400 hover:text-rose-600 transition-colors uppercase tracking-widest">
                            Discard Changes
                        </a>
                        <button type="submit" class="w-full sm:w-auto bg-indigo-900 hover:bg-black text-white font-black py-5 px-14 rounded-2xl shadow-2xl shadow-indigo-200 transition-all transform hover:-translate-y-1 active:scale-95 uppercase tracking-[0.2em] text-sm">
                            Save Book Updates
                        </button>
                    </div>
                </form>
            </div>

            {{-- Footer Note --}}
            <p class="text-center mt-10 text-[10px] text-slate-400 font-black uppercase tracking-[0.5em]">
                University Library Management System &bull; Digital Records
            </p>
        </div>
    </div>
</x-app-layout>