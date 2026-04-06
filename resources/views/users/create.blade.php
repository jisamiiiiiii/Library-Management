<x-app-layout>
    <style>
        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
        select::-ms-expand {
            display: none;
        }
    </style>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('User Registration') }}
            </h2>
            <div class="flex items-center space-x-2 bg-white/50 px-4 py-2 rounded-2xl border border-white shadow-sm">
                <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest text-right leading-tight">
                    Library System<br>Access Control
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-[#f8faff] via-[#eef2ff] to-[#f0f4ff] min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white/80 backdrop-blur-xl shadow-[0_20px_50px_rgba(79,70,229,0.07)] rounded-[2.5rem] border border-white p-12 relative overflow-hidden">
                
                <div class="absolute -top-24 -right-24 w-48 h-48 bg-indigo-200/30 rounded-full blur-3xl"></div>

                <div class="relative">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2 tracking-tight">Create New Account</h3>
                    <p class="text-sm text-gray-400 font-bold mb-10 uppercase tracking-widest">Identity & Access Management</p>

                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        <div class="mb-6">
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                                class="w-full px-6 py-4 rounded-2xl border-white/40 bg-white/60 backdrop-blur-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-700 shadow-sm transition-all placeholder-gray-300"
                                placeholder="Enter full name">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-6 py-4 rounded-2xl border-white/40 bg-white/60 backdrop-blur-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-700 shadow-sm transition-all placeholder-gray-300"
                                placeholder="email@university.edu">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Assign System Role</label>
                            <div class="relative">
                                <select name="role" required
                                    class="w-full pl-6 pr-12 py-4 rounded-2xl border-white/40 bg-white/60 backdrop-blur-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-700 shadow-sm transition-all cursor-pointer">
                                    <option value="" disabled selected>Select a role...</option>
                                    <option value="Student" {{ old('role') == 'Student' ? 'selected' : '' }}>Student (Borrower)</option>
                                    <option value="Librarian" {{ old('role') == 'Librarian' ? 'selected' : '' }}>Librarian (Staff)</option>
                                    <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Administrator</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-6 pointer-events-none text-indigo-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                            <div>
                                <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Password</label>
                                <input type="password" name="password" required
                                    class="w-full px-6 py-4 rounded-2xl border-white/40 bg-white/60 backdrop-blur-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-700 shadow-sm transition-all">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div>
                                <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Confirm Password</label>
                                <input type="password" name="password_confirmation" required
                                    class="w-full px-6 py-4 rounded-2xl border-white/40 bg-white/60 backdrop-blur-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-700 shadow-sm transition-all">
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-8 pt-6 border-t border-gray-50">
                            <a href="{{ route('users.index') }}" class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-400 hover:text-gray-600 transition">
                                Back to Directory
                            </a>
                            <button type="submit" class="px-12 py-4 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-indigo-200 transition transform hover:scale-105 active:scale-95">
                                Register User
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <p class="text-center mt-8 text-[10px] font-bold text-gray-400 uppercase tracking-widest opacity-60">
                Credentials will be encrypted and stored in the secure active directory.
            </p>
        </div>
    </div>
</x-app-layout>