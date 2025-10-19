<x-layouts.dashboard_layout :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl text-black">
        <div class="bg-white">
            <h1 class="text-6xl p-5">Dashboard</h1>
        </div>
        <div class="bg-white p-2">
            <div class="grid grid-cols-3 grid-rows-2 gap-4 *:h-20">
                <div class="col-span-2 row-span-1 relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                    <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                    <h1>Service Attendance</h1>
                </div>
                <div class="col-span-1 row-span-1 relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                    <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                    <h1>Life Guides</h1>
                </div>
                <div class="col-span-1 row-span-1 relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                    <h1>Members</h1>
                </div>
                <div class="col-span-1 row-span-1 relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                    <h1>Donations</h1>
                </div>
                <div class="col-span-1 row-span-1 relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                    <h1>Life Groups</h1>
                </div>
            </div>
        </div>
    </div>
</x-layouts.dashboard_layout>
