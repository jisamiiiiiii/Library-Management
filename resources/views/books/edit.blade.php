<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Book Information') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-bl from-indigo-50 to-blue-100 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white/40 backdrop-blur-md border border-white/20 shadow-xl rounded-2xl p-8">
                
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Edit: {{ $book->title }}</h3>

                <form action="{{ route('books.update', $book->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 uppercase">Book Title</label>
                            <input type="text" name="title" value="{{ $book->title }}" required class="mt-1 block w-full rounded-lg border-gray-300/50 bg-white/50 shadow-sm px-4 py-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 uppercase">Author</label>
                            <input type="text" name="author" value="{{ $book->author }}" required class="mt-1 block w-full rounded-lg border-gray-300/50 bg-white/50 shadow-sm px-4 py-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 uppercase">ISBN Number</label>
                            <input type="text" name="isbn" value="{{ $book->isbn }}" required class="mt-1 block w-full rounded-lg border-gray-300/50 bg-white/50 shadow-sm px-4 py-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 uppercase">Category</label>
                            <select name="category_id" required class="mt-1 block w-full rounded-lg border-gray-300/50 bg-white/50 shadow-sm px-4 py-2">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $book->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 uppercase">Status</label>
                            <select name="status" class="mt-1 block w-full rounded-lg border-gray-300/50 bg-white/50 shadow-sm px-4 py-2">
                                <option value="available" {{ $book->status == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="borrowed" {{ $book->status == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                                <option value="lost" {{ $book->status == 'lost' ? 'selected' : '' }}>Lost</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-end space-x-4">
                        <a href="{{ route('books.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">Cancel</a>
                        <button type="submit" class="bg-indigo-600/80 hover:bg-indigo-700 backdrop-blur-sm text-white font-bold py-2 px-10 rounded-xl shadow-lg transition-all transform hover:scale-105">
                            Update Book
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>