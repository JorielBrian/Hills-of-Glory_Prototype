<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $username = '';
    public string $first_name = '';
    public string $middle_name = '';
    public string $last_name = '';
    public string $age = '';
    public string $gender = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $is_admin = false;

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'username' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'is_admin' => ['boolean'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6 bg-white/40 p-7 rounded-xl">
        <!-- Name -->
        <flux:input
            wire:model="username"
            :label="__('User Name')"
            type="text"
            required
            autofocus
            autocomplete="username"
            :placeholder="__('User Name')"
        />
        <flux:input
            wire:model="first_name"
            :label="__('First Name')"
            type="text"
            required
            autofocus
            autocomplete="first_name"
            :placeholder="__('First Name')"
        />

        <flux:input
            wire:model="middle_name"
            :label="__('Middle Name')"
            type="text"
            required
            autofocus
            autocomplete="middle_name"
            :placeholder="__('Middle Name')"
        />

        <flux:input
            wire:model="last_name"
            :label="__('Last Name')"
            type="text"
            required
            autofocus
            autocomplete="last_name"
            :placeholder="__('Last Name')"
        />

        <div class="flex gap-2">
            <flux:input
                wire:model="age"
                :label="__('Age')"
                type="text"
                required
                autofocus
                autocomplete="age"
                :placeholder="__('Age')"
            />

            <flux:select
                wire:model="gender"
                :label="__('Gender')"
                type="text"
                required
                autofocus
                autocomplete="gender"
                :placeholder="__('Gender')"
            >
                <flux:select.option value="Male" class="option text-zinc-700">Male</flux:select.option>
                <flux:select.option value="Female" class="option text-zinc-700">Female</flux:select.option>
            </flux:select>
        </div>

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Password')"
            viewable
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirm password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirm password')"
            viewable
        />

        <!-- Admin Toggle -->
        <div class="flex items-center justify-between p-4 bg-white/50 rounded-lg border border-gray-200">
            <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-900">Administrator Access</span>
                <span class="text-xs text-gray-600">Grant full administrative privileges to this user</span>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input 
                    type="checkbox" 
                    wire:model="is_admin" 
                    class="sr-only peer"
                >
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
            </label>
        </div>

        <!-- Admin Warning -->
        @if($is_admin)
            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <span class="text-sm font-medium text-yellow-800">Admin Access Enabled</span>
                </div>
                <p class="text-xs text-yellow-700 mt-1">
                    This user will have full administrative privileges across the system.
                </p>
            </div>
        @endif

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-300 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <flux:link class="text-white" :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>