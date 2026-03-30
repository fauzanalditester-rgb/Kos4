<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('admin.dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="mb-10 lg:mb-12">
        <h2 class="text-3xl font-extrabold text-[#333333] mb-2 tracking-tight">Selamat Datang 👋</h2>
        <p class="text-sm font-medium text-gray-500">Silakan masuk menggunakan kredensial pengelola.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-6">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-[#333333] mb-2">Email Address</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                </div>
                <input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username" 
                    class="block w-full pl-11 pr-4 py-3.5 bg-gray-50 border-0 text-[#333333] rounded-2xl focus:bg-white focus:ring-2 focus:ring-[#FFCC00] focus:border-transparent transition-all sm:text-sm shadow-sm hover:bg-gray-100 placeholder-gray-400" placeholder="admin@sewavip.com" />
            </div>
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-red-500 text-xs font-medium" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="block text-sm font-bold text-[#333333]">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-bold text-amber-500 hover:text-amber-600 transition-colors" href="{{ route('password.request') }}" wire:navigate>
                        Lupa password?
                    </a>
                @endif
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <input wire:model="form.password" id="password" type="password" name="password" required autocomplete="current-password"
                    class="block w-full pl-11 pr-4 py-3.5 bg-gray-50 border-0 text-[#333333] rounded-2xl focus:bg-white focus:ring-2 focus:ring-[#FFCC00] focus:border-transparent transition-all sm:text-sm shadow-sm hover:bg-gray-100 placeholder-gray-400" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-red-500 text-xs font-medium" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input wire:model="form.remember" id="remember" type="checkbox" class="h-4 w-4 bg-gray-50 border-gray-300 rounded text-amber-500 focus:ring-amber-500 cursor-pointer" name="remember">
            <label for="remember" class="ml-2 block text-sm font-medium text-gray-500 cursor-pointer">
                Tetap login
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-2xl shadow-sm text-sm font-extrabold text-[#333333] bg-[#FFCC00] hover:bg-[#E6B800] hover:-translate-y-0.5 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FFCC00] uppercase tracking-wide">
                Masuk Dashboard
            </button>
        </div>
    </form>
    
    <div class="mt-12 text-center text-xs text-gray-400 font-medium tracking-wide">
        &copy; {{ date('Y') }} SewaVIP. Secured by System.
    </div>
</div>
