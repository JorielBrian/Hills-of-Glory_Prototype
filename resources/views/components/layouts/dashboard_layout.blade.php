<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        @livewireStyles
    </head>
    <body class="min-h-screen bg-[#f1f1f1] dark:bg-zinc-800">
        {{-- SIDEBAR --}}
        <flux:sidebar sticky stashable class="bg-[#182920] w-110 relative justify-center p-0!">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="/" class="flex fixed top-5 items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <div class="flex pt-3 items-center justify-between gap-2">
                    <img src="/hog_logo.png" alt="logo" class="size-15">
                    <h1 class="text-3xl font-bold text-[#e2b900]">Hills of Glory</h1>
                    <h1 class="text-3xl text-white">Mabalacat</h1>
                </div>
            </a>

            <flux:navlist variant="outline" class="w-full">
                <flux:navlist.group class="grid w-full *:hover:text-white!">
                    <flux:navlist.item icon="window" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate> {{ __('Dashboard') }} </flux:navlist.item>
                    <flux:navlist.item icon="user-group" :href="route('lifegroups')" :current="request()->routeIs('lifegroups')" wire:navigate> {{ __('Life Group') }} </flux:navlist.item>
                    <flux:navlist.item icon="users" :href="route('members')" :current="request()->routeIs('members')" wire:navigate> {{ __('Members') }} </flux:navlist.item>
                    {{-- <flux:navlist.item icon="calendar" :href="route('events')" :current="request()->routeIs('events')" wire:navigate> {{ __('Events') }} </flux:navlist.item>
                    <flux:navlist.item icon="check-circle" :href="route('attendance')" :current="request()->routeIs('attendance')" wire:navigate> {{ __('Attendance') }} </flux:navlist.item>
                    <flux:navlist.item icon="banknotes" :href="route('finances')" :current="request()->routeIs('finance')" wire:navigate> {{ __('Finances') }} </flux:navlist.item>
                    <flux:navlist.item icon="credit-card" :href="route('expense')" :current="request()->routeIs('expense')" wire:navigate> {{ __('Expense') }} </flux:navlist.item>
                    <flux:navlist.item icon="presentation-chart-line" :href="route('report')" :current="request()->routeIs('report')" wire:navigate> {{ __('Report') }} </flux:navlist.item> --}}
                </flux:navlist.group>
            </flux:navlist>
        </flux:sidebar>

        <!-- HEADER -->
        <flux:header class="bg-[#d9dfbc] justify-between h-25 lg:justify-end">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-3" inset="left" />
            <div class="flex relative h-1/2 m-5 items-center">
                <flux:input type="text" class="relative rounded-full bg-white mx-2 content-center overflow-hidden h-10 w-100!" placeholder="Search"></flux:input>
                <span class="font-semibold text-black mx-2">{{ auth()->user()->username }}</span>
                <flux:dropdown position="top">
                    <flux:profile
                        :initials="auth()->user()->initials()"
                        :chevron="false"
                        :avatar="auth()->user()->profile_photo_url ? auth()->user()->profile_photo_url : null"
                        circle
                    />

                    <flux:menu>
                        <flux:menu.radio.group>
                            <div class="p-0 text-sm font-normal">
                                <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                    <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                        <span
                                            class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                        >
                                            {{ auth()->user()->initials() }}
                                        </span>
                                    </span>

                                    <div class="grid flex-1 text-start text-sm leading-tight">
                                        <span class="truncate font-semibold">{{ auth()->user()->username }}</span>
                                        <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                                {{ __('Log Out') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            </div>
        </flux:header>

        <flux:main>
            {{ $slot }}
        </flux:main>
        @livewireScripts
        @fluxScripts
    </body>
</html>