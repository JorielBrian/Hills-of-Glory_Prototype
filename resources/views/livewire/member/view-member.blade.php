<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl text-black p-6">
        <div class="bg-white rounded-lg shadow-sm">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        {{-- <button 
                            wire:click="backToMembers"
                            class="p-2 text-gray-400 hover:text-gray-600 transition duration-150"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </button> --}}
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Member Details</h1>
                            <p class="text-sm text-gray-500">Complete information about the member</p>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        {{-- <button 
                            wire:click="backToMembers"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50"
                        >
                            Back to Members
                        </button> --}}
                        <button 
                            wire:click="editMember"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700"
                        >
                            Edit Member
                        </button>
                        <button 
                            wire:click="removeMember({{ $member->id }})"
                            wire:confirm="Are you sure you want to remove this member from the life group?"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700"
                        >
                            Remove Member
                        </button>
                    </div>
                </div>
            </div>

            <!-- Member Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Column - Profile & Basic Info -->
                    <div class="lg:col-span-1 space-y-6">
                        <!-- Profile Card -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="text-center">
                                @if($member->member_photo)
                                    <img class="h-32 w-32 rounded-full mx-auto object-cover border-4 border-white shadow" 
                                         src="{{ asset('storage/' . $member->member_photo) }}" 
                                         alt="{{ $member->first_name }} {{ $member->last_name }}">
                                @else
                                    <div class="h-32 w-32 rounded-full mx-auto bg-gray-200 border-4 border-white shadow flex items-center justify-center">
                                        <span class="text-2xl font-bold text-gray-500">
                                            {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                                        </span>
                                    </div>
                                @endif
                                <h2 class="mt-4 text-xl font-bold text-gray-900">
                                    {{ $member->first_name }} {{ $member->middle_name ? $member->middle_name . ' ' : '' }}{{ $member->last_name }}
                                </h2>
                                <p class="text-sm text-gray-500">{{ $member->member_role }}</p>
                                
                                <!-- Status Badge -->
                                <div class="mt-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                        {{ $member->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $member->is_active ? 'Active Member' : 'Inactive Member' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Phone</label>
                                    <p class="text-sm text-gray-900">{{ $member->contact ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Address</label>
                                    <p class="text-sm text-gray-900">{{ $member->address ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Invited By</label>
                                    <p class="text-sm text-gray-900">{{ $member->invited_by ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Detailed Information -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Basic Information -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">First Name</label>
                                    <p class="text-sm text-gray-900">{{ $member->first_name }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Middle Name</label>
                                    <p class="text-sm text-gray-900">{{ $member->middle_name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Last Name</label>
                                    <p class="text-sm text-gray-900">{{ $member->last_name }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Age</label>
                                    <p class="text-sm text-gray-900">{{ $member->age }} years old</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Gender</label>
                                    <p class="text-sm text-gray-900">{{ $member->gender }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Birth Date</label>
                                    <p class="text-sm text-gray-900">{{ $member->birth_date->format('F d, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Church Information -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Church Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Member Role</label>
                                    <p class="text-sm text-gray-900">{{ $member->member_role }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Status</label>
                                    <p class="text-sm text-gray-900">{{ $member->status }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Hills Journey</label>
                                    <p class="text-sm text-gray-900">{{ $member->hills_journey ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Membership Date</label>
                                    <p class="text-sm text-gray-900">{{ $member->created_at->format('F d, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Ministry Information -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ministry Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Ministry</label>
                                    <p class="text-sm text-gray-900">{{ $member->ministry ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Ministry Role</label>
                                    <p class="text-sm text-gray-900">{{ $member->ministry_role ?? 'N/A' }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="text-sm font-medium text-gray-500">Ministry Assignment</label>
                                    <p class="text-sm text-gray-900">{{ $member->ministry_assignment ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Life Group Information -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Life Group Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Life Group</label>
                                    <p class="text-sm text-gray-900">
                                        @if($member->lifegroup)
                                            {{ $member->lifegroup->life_group_name }}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Network Leader</label>
                                    <p class="text-sm text-gray-900">
                                        @if($member->networkLeader)
                                            {{ $member->networkLeader->first_name . " " . $member->networkLeader->last_name}}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>