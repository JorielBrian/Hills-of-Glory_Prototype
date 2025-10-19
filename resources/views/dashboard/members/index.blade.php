<x-layouts.dashboard_layout :title="__('Members')">
    <div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl text-black">
        <div class="bg-white">
            <h1 class="text-6xl p-5">Members</h1>
        </div>
        <div class="bg-white p-2">
                <livewire:member.members-table />
        </div>
    </div>
</x-layouts.dashboard_layout>
