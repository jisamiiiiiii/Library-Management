<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Book to Inventory') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white/40 backdrop-blur-md border border-white/20 shadow-xl rounded-2xl p-8">
                
                <h3 class="text-2xl font-bold text-gray-800 mb-6">University Library Details</h3>

                {{-- Important: Added enctype for image uploads --}}
                <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Title --}}
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Book Title</label>
                            <input type="text" name="title" required class="mt-1 block w-full rounded-lg border-gray-300/50 bg-white/50 focus:ring-blue-500 focus:border-blue-500 shadow-sm px-4 py-2">
                        </div>

                        {{-- Author --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Author</label>
                            <input type="text" name="author" required class="mt-1 block w-full rounded-lg border-gray-300/50 bg-white/50 shadow-sm px-4 py-2">
                        </div>

                        {{-- ISBN --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 uppercase tracking-wider">ISBN Number</label>
                            <input type="text" name="isbn" required class="mt-1 block w-full rounded-lg border-gray-300/50 bg-white/50 shadow-sm px-4 py-2">
                        </div>

                        {{-- Category --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Academic Category</label>
                            <select name="category_id" required class="mt-1 block w-full rounded-lg border-gray-300/50 bg-white/50 shadow-sm px-4 py-2">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Department --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 uppercase tracking-wider">University Department</label>
                            <select name="department" required class="mt-1 block w-full rounded-lg border-gray-300/50 bg-white/50 shadow-sm px-4 py-2">
                                <option value="BSIT">College of Computer Computing</option>
                                <option value="Engineering">College of Engineering</option>
                                <option value="Nursing">College of Nursing</option>
                                <option value="Education">College of Education</option>
                                <option value="Business">College of Business</option>
                            </select>
                        </div>

                        {{-- Physical Location --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Physical Location (Shelf)</label>
                            <input type="text" name="location" placeholder="e.g. Shelf A-10" class="mt-1 block w-full rounded-lg border-gray-300/50 bg-white/50 shadow-sm px-4 py-2">
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Initial Status</label>
                            <select name="status" class="mt-1 block w-full rounded-lg border-gray-300/50 bg-white/50 shadow-sm px-4 py-2">
                                <option value="available">Available</option>
                                <option value="borrowed">Borrowed</option>
                                <option value="lost">Lost</option>
                            </select>
                        </div>

                        {{-- Description (The "Content" expansion) --}}
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Book Summary / Content Abstract</label>
                            <textarea name="description" rows="4" class="mt-1 block w-full rounded-lg border-gray-300/50 bg-white/50 shadow-sm px-4 py-2" placeholder="Provide a brief overview of the book's contents..."></textarea>
                        </div>

                        {{-- Cover Image --}}
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 uppercase tracking-wider">Book Cover Image</label>
                            <input type="file" name="cover_image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-end space-x-4">
                        <a href="{{ route('books.index') }}" class="text-gray-600 hover:text-gray-900 font-medium transition-colors">Cancel</a>
                        <button type="submit" class="bg-indigo-600/80 hover:bg-indigo-700 backdrop-blur-sm text-white font-bold py-2 px-10 rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105">
                            Register Book
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>