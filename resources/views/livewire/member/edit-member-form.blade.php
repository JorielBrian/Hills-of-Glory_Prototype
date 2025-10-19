<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl text-black p-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Edit Member: {{ $member->first_name }} {{ $member->last_name }}</h1>
                <a href="{{ route('members.show', $member) }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                    Back to Member Details
                </a>
            </div>

            <!-- Success Message -->
            @if (session()->has('message'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Error Message -->
            @if (session()->has('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit.prevent="updateMember" class="space-y-6" enctype="multipart/form-data">
                <!-- Basic Information Section -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h2>
                    
                    <!-- Member Photo -->
                    <div class="mb-6">
                        <label for="new_member_photo" class="block text-sm font-medium text-gray-700">Member Photo</label>
                        
                        <!-- Current Photo -->
                        @if ($member_photo)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Photo</label>
                                <div class="border border-gray-300 rounded-md p-4 bg-white inline-block">
                                    <img src="{{ asset('storage/' . $member_photo) }}" 
                                         alt="Current member photo" 
                                         class="h-32 w-32 rounded-lg object-cover">
                                </div>
                            </div>
                        @endif

                        <input type="file" wire:model="new_member_photo" id="new_member_photo" accept="image/*"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('new_member_photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        <p class="mt-1 text-sm text-gray-500">Upload a new photo for the member (optional, max 2MB)</p>
                        
                        <!-- New Photo Preview -->
                        @if ($new_member_photo)
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">New Photo Preview</label>
                                <div class="border border-gray-300 rounded-md p-4 bg-white">
                                    <img src="{{ $new_member_photo->temporaryUrl() }}" 
                                         alt="New member photo preview" 
                                         class="max-w-full h-auto max-h-48 mx-auto rounded-lg">
                                    <p class="text-xs text-gray-500 text-center mt-2">Live preview of the new photo</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- First Name -->
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name *</label>
                            <input type="text" wire:model="first_name" id="first_name" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('first_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Middle Name -->
                        <div>
                            <label for="middle_name" class="block text-sm font-medium text-gray-700">Middle Name</label>
                            <input type="text" wire:model="middle_name" id="middle_name"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('middle_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Last Name -->
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name *</label>
                            <input type="text" wire:model="last_name" id="last_name" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('last_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                        <!-- Age -->
                        <div>
                            <label for="age" class="block text-sm font-medium text-gray-700">Age *</label>
                            <input type="number" wire:model="age" id="age" required min="1"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('age') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Gender -->
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700">Gender *</label>
                            <select wire:model="gender" id="gender" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Gender</option>
                                @foreach($genders as $genderOption)
                                    <option value="{{ $genderOption->value }}">{{ $genderOption->value }}</option>
                                @endforeach
                            </select>
                            @error('gender') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Birth Date -->
                        <div>
                            <label for="birth_date" class="block text-sm font-medium text-gray-700">Birth Date *</label>
                            <input type="date" wire:model="birth_date" id="birth_date" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('birth_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Contact -->
                        <div>
                            <label for="contact" class="block text-sm font-medium text-gray-700">Contact *</label>
                            <input type="text" wire:model="contact" id="contact" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                placeholder="e.g., 09123456789">
                            @error('contact') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="mt-4">
                        <label for="address" class="block text-sm font-medium text-gray-700">Address *</label>
                        <textarea wire:model="address" id="address" required rows="3"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                        @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Church Information Section -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Church Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                            <select wire:model="status" id="status" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Status</option>
                                @foreach($statuses as $statusOption)
                                    <option value="{{ $statusOption->value }}">{{ $statusOption->value }}</option>
                                @endforeach
                            </select>
                            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Invited By -->
                        <div>
                            <label for="invitedBy" class="block text-sm font-medium text-gray-700">Invited By</label>
                            <input type="text" wire:model="invitedBy" id="invitedBy"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('invitedBy') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Member Role -->
                        <div>
                            <label for="member_role" class="block text-sm font-medium text-gray-700">Member Role *</label>
                            <select wire:model="member_role" id="member_role" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Role</option>
                                @foreach($memberRoles as $role)
                                    <option value="{{ $role->value }}">{{ $role->value }}</option>
                                @endforeach
                            </select>
                            @error('member_role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Hills Journey -->
                        <div>
                            <label for="hills_journey" class="block text-sm font-medium text-gray-700">Hills Journey *</label>
                            <select wire:model="hills_journey" id="hills_journey" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Hills Journey</option>
                                @foreach($hills_journeys as $journey)
                                    <option value="{{ $journey->value }}">{{ $journey->value }}</option>
                                @endforeach
                            </select>
                            @error('hills_journey') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Ministry Information Section -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Ministry Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Ministry -->
                        <div>
                            <label for="ministry" class="block text-sm font-medium text-gray-700">Ministry</label>
                            <select wire:model="ministry" id="ministry"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Ministry</option>
                                @foreach($ministries as $ministryOption)
                                    <option value="{{ $ministryOption->value }}">{{ $ministryOption->value }}</option>
                                @endforeach
                            </select>
                            @error('ministry') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Ministry Role -->
                        <div>
                            <label for="ministry_role" class="block text-sm font-medium text-gray-700">Ministry Role</label>
                            <select wire:model="ministry_role" id="ministry_role"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Role</option>
                                @foreach($ministry_roles as $role)
                                    <option value="{{ $role->value }}">{{ $role->value }}</option>
                                @endforeach
                            </select>
                            @error('ministry_role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Ministry Assignment -->
                        <div>
                            <label for="ministry_assignment" class="block text-sm font-medium text-gray-700">Ministry Assignment</label>
                            <input type="text" wire:model="ministry_assignment" id="ministry_assignment"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('ministry_assignment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Life Group Section -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Life Group</h2>
                    
                    <div>
                        <label for="life_group" class="block text-sm font-medium text-gray-700">Life Group</label>
                        <select wire:model="life_group" id="life_group"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Life Group</option>
                            @foreach($lifeGroups as $lifeGroup)
                                <option value="{{ $lifeGroup->id }}">{{ $lifeGroup->life_group_name }}</option>
                            @endforeach
                        </select>
                        @error('life_group') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        
                        <!-- Network Leader Display -->
                        @if ($life_group)
                            @php
                                $selectedLifeGroup = $lifeGroups->firstWhere('id', $life_group);
                            @endphp
                            @if ($selectedLifeGroup && $selectedLifeGroup->networkLeader)
                                <div class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-md">
                                    <p class="text-sm text-blue-800">
                                        <strong>Network Leader:</strong> 
                                        {{ $selectedLifeGroup->networkLeader->first_name }} 
                                        {{ $selectedLifeGroup->networkLeader->last_name }}
                                    </p>
                                    <p class="text-xs text-blue-600 mt-1">
                                        This network leader will be automatically assigned to the member.
                                    </p>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-6">
                    <button 
                        type="button"
                        wire:click="backToMember"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        Update Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>