<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('User Management') }}
            </h2>
            <div class="flex items-center space-x-2 bg-white/50 px-4 py-2 rounded-2xl border border-white shadow-sm">
                <div class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></div>
                <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Active Directory</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-[#f8faff] via-[#eef2ff] to-[#f0f4ff] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Success Notification --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6 p-4 bg-emerald-500/20 backdrop-blur-md border border-emerald-500/50 text-emerald-700 rounded-2xl shadow-lg flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="font-bold">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-800 opacity-50 hover:opacity-100 transition">&times;</button>
                </div>
            @endif

            {{-- Search & Filter Section --}}
            <div class="mb-10">
                <form action="{{ route('users.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    @if(request('role'))
                        <input type="hidden" name="role" value="{{ request('role') }}">
                    @endif

                    <div class="relative flex-grow">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-5">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Search by Name, Email, or Role..." 
                            class="block w-full pl-14 pr-6 py-4 border border-white/40 rounded-2xl bg-white/60 backdrop-blur-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-700 shadow-xl shadow-indigo-100/20 transition-all placeholder-gray-400 border">
                    </div>
                    
                    <div class="flex gap-2">
                        <button type="submit" class="px-10 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-lg shadow-indigo-200 transition-all transform hover:scale-105 active:scale-95">
                            Search
                        </button>
                        @if(request('search') || request('role'))
                            <a href="{{ route('users.index') }}" class="px-6 py-4 bg-white/80 hover:bg-white text-gray-600 font-bold rounded-2xl shadow-md border border-gray-200 transition-all flex items-center justify-center">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Tab Navigation --}}
            <div class="flex items-center space-x-8 mb-8 ml-2">
                <a href="{{ route('users.index') }}" 
                   class="text-xs font-black uppercase tracking-widest transition pb-2 border-b-2 {{ !request('role') ? 'text-indigo-600 border-indigo-600' : 'text-gray-400 border-transparent hover:text-gray-600' }}">
                    All Users <span class="ml-1 opacity-50">({{ $allCount }})</span>
                </a>

                <a href="{{ route('users.index', ['role' => 'Student']) }}" 
                   class="text-xs font-black uppercase tracking-widest transition pb-2 border-b-2 {{ request('role') === 'Student' ? 'text-indigo-600 border-indigo-600' : 'text-gray-400 border-transparent hover:text-gray-600' }}">
                    Students <span class="ml-1 opacity-50">({{ $studentCount }})</span>
                </a>

                <a href="{{ route('users.index', ['role' => 'Librarian']) }}" 
                   class="text-xs font-black uppercase tracking-widest transition pb-2 border-b-2 {{ request('role') === 'Librarian' ? 'text-indigo-600 border-indigo-600' : 'text-gray-400 border-transparent hover:text-gray-600' }}">
                    Librarians <span class="ml-1 opacity-50">({{ $librarianCount }})</span>
                </a>
            </div>

            {{-- Main Table Container --}}
            <div class="bg-white/80 backdrop-blur-xl shadow-[0_20px_50px_rgba(79,70,229,0.07)] rounded-[2.5rem] overflow-hidden border border-white">
                <div class="px-12 py-10 flex justify-between items-center bg-white/20">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 tracking-tight">Member Directory</h3>
                        <p class="text-sm text-gray-400 font-bold mt-1 uppercase tracking-tighter">
                            {{ request('role') ?? 'All Members' }} List
                        </p>
                    </div>
                    
                    <a href="{{ route('users.create') }}" class="px-8 py-3 bg-[#5e92f3] text-white rounded-2xl text-sm font-bold shadow-lg shadow-blue-100 hover:bg-[#4a7dce] transition transform active:scale-95 text-center">
                        + Register User
                    </a>
                </div>

                <div class="overflow-x-auto px-12 pb-12">
                    <table class="w-full text-left table-auto">
                        <thead>
                            <tr class="text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em] border-b border-gray-50">
                                <th class="pb-6">Type</th>
                                <th class="pb-6">Identity</th>
                                <th class="pb-6">Access Level</th>
                                <th class="pb-6">Status</th>
                                <th class="pb-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50/80">
                            @forelse($users as $user)
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                @php
                                    $rawRole = $user->role ?? 'Student';
                                    $cleanRole = strtolower($rawRole);
                                @endphp

                                <td class="py-7">
                                    <div class="flex items-center">
                                        @if($cleanRole == 'admin')
                                            <div class="w-9 h-9 bg-purple-100 rounded-xl flex items-center justify-center border border-purple-200">
                                                <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20"><path d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"/></svg>
                                            </div>
                                        @elseif($cleanRole == 'librarian')
                                            <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center border border-blue-200">
                                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/></svg>
                                            </div>
                                        @else
                                            <div class="w-9 h-9 bg-indigo-50 rounded-xl flex items-center justify-center border border-indigo-100">
                                                <svg class="w-4 h-4 text-indigo-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                
                                <td class="py-7">
                                    <div class="text-sm font-bold text-gray-900 leading-none">{{ $user->name }}</div>
                                    <div class="text-[11px] text-gray-400 mt-1.5 font-medium italic">{{ $user->email }}</div>
                                </td>

                                <td class="py-7">
                                    @php
                                        $roleStyles = [
                                            'admin' => 'bg-purple-50 text-purple-600 border-purple-100',
                                            'librarian' => 'bg-blue-50 text-blue-600 border-blue-100',
                                            'student' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                        ];
                                        $badgeStyle = $roleStyles[$cleanRole] ?? 'bg-gray-50 text-gray-500 border-gray-100';
                                    @endphp
                                    <span class="px-3 py-1 rounded-md text-[10px] font-black uppercase tracking-tighter border {{ $badgeStyle }}">
                                        {{ $rawRole }}
                                    </span>
                                </td>

                                <td class="py-7">
                                    <span class="flex items-center text-[10px] font-black text-green-600 uppercase tracking-widest">
                                        <span class="h-1.5 w-1.5 rounded-full bg-green-500 mr-2 shadow-[0_0_8px_rgba(34,197,94,0.4)]"></span>
                                        Active
                                    </span>
                                </td>

                                <td class="py-7 text-right">
                                    <div class="flex justify-end items-center gap-5">
                                        {{-- FIXED LINK: Added route and click stop --}}
                                        <a href="{{ route('users.edit', $user->id) }}" 
                                           @click.stop
                                           class="relative z-10 text-[#5d5bf4] hover:text-indigo-800 text-[11px] font-black uppercase tracking-widest transition leading-none border-b border-transparent hover:border-indigo-800">
                                            Manage
                                        </a>
                                        
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Revoke access for this user?')" class="inline-flex m-0 p-0 relative z-10">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" @click.stop class="text-red-400 hover:text-red-600 text-[11px] font-black uppercase tracking-widest transition leading-none">
                                                Revoke
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-24 text-center text-gray-400 italic font-medium">
                                    No records found in the directory.
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