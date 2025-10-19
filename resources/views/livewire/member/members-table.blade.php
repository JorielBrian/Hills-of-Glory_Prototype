<div>
    <!-- Search and Filter Section -->
    <div class="mb-6 space-y-4">
        <!-- Search Bar -->
        <div class="flex items-center justify-between">
            <div class="flex-1 max-w-md">
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        wire:model.live="search"
                        placeholder="Search members by name or contact..."
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>
            </div>
            
            <div class="flex gap-2">
                <flux:button :href="route('members.create')">
                    Add Member
                </flux:button>
            </div>
        </div>

        <!-- Network Leader Filter -->
        {{-- <div class="flex items-center space-x-4">
            <div class="flex items-center space-x-2">
                <select 
                    wire:model.live="network_leader" 
                    id="network_leader"
                    class="border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                >
                    <option value="">Filter by Network Leader</option>
                    @foreach($network_leaders as $net_leader)
                        <option value="{{ $net_leader->value }}">
                            {{ $net_leader->label() }}
                        </option>
                    @endforeach
                </select>
                
                <!-- Clear Filter Button -->
                @if($network_leader)
                    <button 
                        wire:click="network_leader = ''" 
                        class="px-3 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-sm"
                    >
                        Clear Filter
                    </button>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Filter Status -->
    @if($network_leader || $search)
    <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-md">
        <span class="text-sm text-blue-700">
            @if($network_leader && $search)
                Showing members for: 
                <strong>{{ \App\Enums\MemberEnums\NetworkLeaders::from($network_leader)->label() }}</strong>
                and matching search: <strong>"{{ $search }}"</strong>
            @elseif($network_leader)
                Showing members for: 
                <strong>{{ \App\Enums\MemberEnums\NetworkLeaders::from($network_leader)->label() }}</strong>
            @elseif($search)
                Showing members matching: <strong>"{{ $search }}"</strong>
            @endif
        </span>
    </div>
    @endif --}}

    <!-- Table Container -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Responsive Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Network Leader</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ministry</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ministry Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Birthday</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hills Journey</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($members as $member)
                        <tr 
                            wire:click="viewMember({{ $member->id }})"
                            class="hover:bg-gray-50 cursor-pointer transition duration-150 ease-in-out"
                        >
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($member->member_photo)
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover" 
                                                 src="{{ asset('storage/' . $member->member_photo) }}" 
                                                 alt="{{ $member->first_name }} {{ $member->last_name }}">
                                        </div>
                                    @else
                                        <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                            <span class="text-gray-500 font-medium text-sm">
                                                {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                                            </span>
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $member->first_name }} {{ $member->middle_name ? $member->middle_name . ' ' : '' }}{{ $member->last_name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $member->member_role }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($member->networkLeader)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $member->networkLeader->first_name ." ". $member->networkLeader->last_name ?? 'N/A' }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-500">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $member->ministry ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $member->ministry_role ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $member->contact ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $member->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $member->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $member->gender ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $member->birth_date?->format('M d, Y') ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $member->hills_journey ?? 'N/A' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-lg font-medium text-gray-900">No members found</p>
                                    <p class="text-gray-500 mt-1">
                                        @if($network_leader || $search)
                                            Try adjusting your filter criteria
                                        @else
                                            No members have been added yet
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($members->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $members->links() }}
            </div>
        @endif
    </div>
</div>