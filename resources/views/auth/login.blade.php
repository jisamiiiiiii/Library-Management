<x-guest-layout>
    {{-- Background Layer --}}
    <div class="fixed inset-0 z-0">
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" 
             style="background-image: url('https://erasmus.uni-sofia.bg/site/income/wp-content/uploads/sites/3/2016/05/ub_2.jpg');">
        </div>
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[2px]"></div>
    </div>

    <div class="relative z-10 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        
        {{-- University Logo Section --}}
        <div class="mb-6 transition-transform hover:scale-105 duration-500">
            <a href="/">
                <img src="{{ asset('images/Screenshot_2026-04-30_094359-removebg-preview (2).png') }}" 
                     alt="University Logo" 
                     class="h-28 w-auto drop-shadow-[0_10px_10px_rgba(0,0,0,0.5)]">
            </a>
        </div>

        {{-- Login Card --}}
        <div class="w-full sm:max-w-md px-8 py-10 bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_25px_50px_-12px_rgba(0,0,0,0.5)] overflow-hidden sm:rounded-[2rem]">
            
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-black text-white tracking-widest uppercase italic">LogIn Account</h2>
                <div class="h-1 w-12 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto mt-4 rounded-full"></div>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email Field --}}
                <div class="group">
                    <label for="email" class="block font-black text-[10px] text-indigo-200 uppercase tracking-widest ml-1 mb-1">{{ __('Institutional Email') }}</label>
                    <x-text-input id="email" 
                        class="block w-full bg-white/5 border-white/10 text-white placeholder-white/20 focus:ring-indigo-500/50 focus:border-indigo-500 focus:bg-white/10 transition-all duration-300 rounded-xl" 
                        type="email" name="email" :value="old('email')" required autofocus placeholder="name@university.edu" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-rose-400 font-bold" />
                </div>

                {{-- Password Field with Eye Toggle --}}
                <div class="mt-6 group" x-data="{ show: false }">
                    <label for="password" class="block font-black text-[10px] text-indigo-200 uppercase tracking-widest ml-1 mb-1">{{ __('Password') }}</label>
                    
                    <div class="relative">
                        <x-text-input id="password" 
                            class="block w-full bg-white/5 border-white/10 text-white placeholder-white/20 focus:ring-indigo-500/50 focus:border-indigo-500 focus:bg-white/10 transition-all duration-300 rounded-xl pr-12"
                            ::type="show ? 'text' : 'password'"
                            name="password"
                            required placeholder="••••••••" />
                        
                        <!-- Eye Icon Button -->
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-white/50 hover:text-white transition-colors">
                            <!-- Eye Open -->
                            <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <!-- Eye Closed -->
                            <svg x-show="show" style="display: none;" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                    
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-rose-400 font-bold" />
                </div>

                {{-- Remember & Options --}}
                <div class="flex items-center justify-between mt-6">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                        <input id="remember_me" type="checkbox" class="rounded-md border-white/20 bg-white/5 text-indigo-600 shadow-sm focus:ring-indigo-500 focus:ring-offset-0 transition" name="remember">
                        <span class="ms-2 text-[11px] font-bold text-white/60 group-hover:text-white transition uppercase tracking-tighter">{{ __('Remember Me') }}</span>
                    </label>
                </div>

                <div class="mt-10">
                    <x-primary-button class="w-full justify-center py-4 bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 !text-white border-none transition-all duration-300 font-black uppercase tracking-[0.2em] shadow-xl shadow-indigo-900/20 rounded-xl">
                        {{ __('Login') }}
                    </x-primary-button>

                    <div class="grid grid-cols-2 gap-4 mt-8 pt-6 border-t border-white/10">
                        @if (Route::has('password.request'))
                            <a class="text-[10px] font-bold text-white/40 hover:text-indigo-300 transition uppercase text-left tracking-tighter" href="{{ route('password.request') }}">
                                {{ __('Forgot Password?') }}
                            </a>
                        @endif

                        <a class="text-[10px] font-bold text-indigo-400 hover:text-indigo-300 transition uppercase text-right tracking-tighter" href="{{ route('register') }}">
                            {{ __('Register Here') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
        
        
    </div>
</x-guest-layout>