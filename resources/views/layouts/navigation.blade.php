<nav x-data="{ open: false }" class="bg-[#0f172a] border-b border-[#1e293b] shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-12 w-auto" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                            class="text-slate-300 hover:text-white border-[#6b21a8] transition duration-150">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endauth

                    <x-nav-link :href="route('books.index')" :active="request()->routeIs('books.*')"
                        class="text-slate-300 hover:text-white border-[#6b21a8] transition duration-150">
                        {{ __('Library Inventory') }}
                    </x-nav-link>

                    @auth
                        @if(Auth::user()->role === 'Student')
                            <x-nav-link :href="route('borrows.index')" :active="request()->routeIs('borrows.index')"
                                class="text-slate-300 hover:text-white border-[#6b21a8]">
                                {{ __('My Borrows') }}
                            </x-nav-link>
                        @endif

                        @if(in_array(Auth::user()->role, ['Admin', 'Librarian']))
                            <x-nav-link :href="route('borrows.index')" :active="request()->routeIs('admin.borrows.index')"
                                class="text-slate-300 hover:text-white border-[#6b21a8]">
                                {{ __('Manage Requests') }}
                            </x-nav-link>
                        @endif

                        @if(Auth::user()->role === 'Admin')
                            <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')"
                                class="text-slate-300 hover:text-white border-[#6b21a8]">
                                {{ __('User Management') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-4 py-2 border border-[#334155] text-sm leading-4 font-medium rounded-lg text-slate-300 bg-[#1e293b] hover:text-white hover:border-[#6b21a8] focus:outline-none transition ease-in-out duration-150 shadow-sm">
                                <div class="flex flex-col items-end">
    <span class="font-bold text-white uppercase text-[12px] tracking-tight">
        {{ Auth::user()->name }}
    </span>
    
    <span class="text-[9px] uppercase tracking-widest font-black 
        {{ Auth::user()->role === 'Admin' ? 'text-rose-400' : 
          (Auth::user()->role === 'Librarian' ? 'text-amber-400' : 'text-emerald-400') }}">
        
        @if(Auth::user()->role === 'Admin')
            {{ __('Admin') }}
        @elseif(Auth::user()->role === 'Librarian')
            {{ __('Librarian') }}
        @else
            {{ __('Student') }}
        @endif
    </span>
</div>

                                <div class="ms-3 text-slate-500">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="space-x-3">
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-300 hover:text-white">Log in</a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-[#6b21a8] text-white text-xs font-bold rounded-lg hover:bg-[#581c87] transition shadow-md">Register</a>
                    </div>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-white hover:bg-[#1e293b] focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#0f172a] border-t border-[#1e293b]">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('books.index')" :active="request()->routeIs('books.*')" class="text-slate-300">
                {{ __('Library Inventory') }}
            </x-responsive-nav-link>

            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-slate-300">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                @if(Auth::user()->role === 'Admin')
                    <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" class="text-rose-400 font-bold">
                        {{ __('User Management') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-[#1e293b]">
                <div class="px-4">
                    <div class="font-bold text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-slate-400">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-slate-300">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();" class="text-slate-300">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>