<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public string $username = '';
    public string $first_name = '';
    public string $middle_name = '';
    public string $last_name = '';
    public string $age = '';
    public string $gender = '';
    public string $email = '';
    public $profile_photo;
    public $new_profile_photo;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->username = $user->username;
        $this->first_name = $user->first_name;
        $this->middle_name = $user->middle_name ?? '';
        $this->last_name = $user->last_name;
        $this->age = (string) $user->age;
        $this->gender = $user->gender;
        $this->email = $user->email;
        $this->profile_photo = $user->profile_photo;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:1'],
            'gender' => ['required', 'string', 'in:Male,Female'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id)
            ],
            'new_profile_photo' => ['nullable', 'image', 'max:2048'], // 2MB max
        ]);

        // Handle profile photo upload
        if ($this->new_profile_photo) {
            // Delete old photo if exists
            if ($this->profile_photo && Storage::disk('public')->exists($this->profile_photo)) {
                Storage::disk('public')->delete($this->profile_photo);
            }
            $validated['profile_photo'] = $this->new_profile_photo->store('profile-photos', 'public');
        }

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Reset the new photo property
        $this->new_profile_photo = null;
        $this->profile_photo = $user->profile_photo;

        $this->dispatch('profile-updated', name: $user->first_name);
    }

    /**
     * Delete the current profile photo.
     */
    public function deleteProfilePhoto(): void
    {
        $user = Auth::user();

        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $user->forceFill([
            'profile_photo' => null,
        ])->save();

        $this->profile_photo = null;
        $this->new_profile_photo = null;

        $this->dispatch('profile-updated');
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));
            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your profile information and photo')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6" enctype="multipart/form-data">
            <!-- Profile Photo -->
            <div class="space-y-4">
                <label class="block text-sm font-medium text-gray-700">{{ __('Profile Photo') }}</label>
                
                <div class="flex items-center gap-6">
                    <!-- Current Photo -->
                    @if ($profile_photo)
                        <div class="relative">
                            <img src="{{ asset('storage/' . $profile_photo) }}" 
                                 alt="{{ __('Profile Photo') }}" 
                                 class="h-20 w-20 rounded-full object-cover border-2 border-gray-200">
                            <button type="button" 
                                    wire:click="deleteProfilePhoto"
                                    class="absolute -top-1 -right-1 p-1 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors duration-200"
                                    title="{{ __('Remove photo') }}">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    @else
                        <div class="h-20 w-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-xl">
                            {{ Auth::user()->initials() }}
                        </div>
                    @endif

                    <!-- Photo Upload -->
                    <div class="flex-1">
                        <input type="file" 
                               wire:model="new_profile_photo" 
                               accept="image/*"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @error('new_profile_photo') 
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">{{ __('Upload a new profile photo (JPG, PNG, max 2MB)') }}</p>
                        
                        <!-- New Photo Preview -->
                        @if ($new_profile_photo)
                            <div class="mt-2">
                                <p class="text-sm text-gray-600 mb-1">{{ __('Preview:') }}</p>
                                <img src="{{ $new_profile_photo->temporaryUrl() }}" 
                                     alt="{{ __('New profile photo preview') }}" 
                                     class="h-16 w-16 rounded-full object-cover border border-gray-300">
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:input 
                    wire:model="username" 
                    :label="__('Username')" 
                    type="text" 
                    required 
                    autocomplete="username" 
                    :placeholder="__('Username')" 
                />

                <flux:input 
                    wire:model="email" 
                    :label="__('Email')" 
                    type="email" 
                    required 
                    autocomplete="email" 
                    placeholder="email@example.com" 
                />
            </div>

            <!-- Personal Information -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <flux:input 
                    wire:model="first_name" 
                    :label="__('First Name')" 
                    type="text" 
                    required 
                    autocomplete="given-name" 
                    :placeholder="__('First Name')" 
                />

                <flux:input 
                    wire:model="middle_name" 
                    :label="__('Middle Name')" 
                    type="text" 
                    autocomplete="additional-name" 
                    :placeholder="__('Middle Name')" 
                />

                <flux:input 
                    wire:model="last_name" 
                    :label="__('Last Name')" 
                    type="text" 
                    required 
                    autocomplete="family-name" 
                    :placeholder="__('Last Name')" 
                />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:input 
                    wire:model="age" 
                    :label="__('Age')" 
                    type="number" 
                    required 
                    min="1" 
                    autocomplete="age" 
                    :placeholder="__('Age')" 
                />

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Gender') }}</label>
                    <select wire:model="gender" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">{{ __('Select Gender') }}</option>
                        <option value="Male">{{ __('Male') }}</option>
                        <option value="Female">{{ __('Female') }}</option>
                    </select>
                    @error('gender') 
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                    @enderror
                </div>
            </div>

            <!-- Email Verification Section -->
            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <flux:text>
                        {{ __('Your email address is unverified.') }}

                        <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                            {{ __('Click here to re-send the verification email.') }}
                        </flux:link>
                    </flux:text>

                    @if (session('status') === 'verification-link-sent')
                        <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </flux:text>
                    @endif
                </div>
            @endif

            <!-- Save Button -->
            <div class="flex items-center gap-4 pt-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full md:w-auto">
                        {{ __('Save Changes') }}
                    </flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>