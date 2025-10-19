<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl text-black p-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">My Life Groups</h1>
                    <p class="text-gray-600 mt-1">Manage your assigned life groups</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        Network Leader: {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} 
                    </span>
                </div>
                <div class="flex flex-col mt-4 sm:mt-0">
                    <flux:button :href="route('lifegroups.create')">
                        Add Lifegroup
                    </flux:button>
                </div>
            </div>

            <!-- Filters -->
            <div class="mb-6 flex flex-col sm:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <input 
                        type="text" 
                        wire:model.live="search" 
                        placeholder="Search life groups..." 
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>
                
                <!-- Status Filter -->
                <div class="sm:w-48">
                    <select 
                        wire:model.live="statusFilter" 
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="all">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <!-- Success Message -->
            @if (session()->has('message'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Life Groups Grid -->
            @if($lifeGroups->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($lifeGroups as $lifeGroup)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200" wire:navigate href="{{ route('life-groups.show', $lifeGroup) }}">
                            <!-- Life Group Photo -->
                            @if($lifeGroup->life_group_photo)
                                <div class="h-48 overflow-hidden rounded-t-lg">
                                    <img 
                                        src="{{ asset('storage/' . $lifeGroup->life_group_photo) }}" 
                                        alt="{{ $lifeGroup->life_group_name }}"
                                        class="w-full h-full object-cover"
                                    >
                                </div>
                            @else
                                <div class="h-48 bg-gradient-to-br from-blue-500 to-blue-600 rounded-t-lg flex items-center justify-center">
                                    <span class="text-white text-4xl font-bold">{{ substr($lifeGroup->life_group_name, 0, 2) }}</span>
                                </div>
                            @endif

                            <!-- Life Group Info -->
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-xl font-semibold text-gray-900">{{ $lifeGroup->life_group_name }}</h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $lifeGroup->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $lifeGroup->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>

                                <div class="space-y-2 text-sm text-gray-600 mb-4">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>{{ $lifeGroup->total_members }} members</span>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>Created {{ $lifeGroup->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $lifeGroups->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No life groups found</h3>
                    <p class="mt-2 text-gray-500">
                        @if($search || $statusFilter !== 'all')
                            Try adjusting your search or filter criteria.
                        @else
                            You don't have any life groups assigned yet.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>