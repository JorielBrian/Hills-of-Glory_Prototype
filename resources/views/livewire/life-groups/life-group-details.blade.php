<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl text-black p-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <!-- Header -->
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6">
                <div class="flex items-start space-x-4">
                    <!-- Life Group Photo -->
                    @if($lifeGroup->life_group_photo)
                        <div class="h-20 w-20 rounded-lg overflow-hidden flex-shrink-0">
                            <img 
                                src="{{ asset('storage/' . $lifeGroup->life_group_photo) }}" 
                                alt="{{ $lifeGroup->life_group_name }}"
                                class="h-full w-full object-cover"
                            >
                        </div>
                    @else
                        <div class="h-20 w-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="text-white text-2xl font-bold">{{ substr($lifeGroup->life_group_name, 0, 2) }}</span>
                        </div>
                    @endif

                    <div>
                        <div class="flex items-center space-x-3">
                            <h1 class="text-2xl font-bold text-gray-900">{{ $lifeGroup->life_group_name }}</h1>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $lifeGroup->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $lifeGroup->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <p class="text-gray-600 mt-1">
                            Network Leader: 
                            <span class="font-medium">{{ $lifeGroup->networkLeader->name }}</span>
                        </p>
                        <p class="text-sm text-gray-500 mt-1">
                            Created {{ $lifeGroup->created_at->format('F d, Y') }}
                        </p>
                    </div>
                </div>

                <div class="mt-4 lg:mt-0 flex space-x-3">
                    <a 
                        href="{{ route('lifegroups') }}" 
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50"
                    >
                        Back to List
                    </a>
                    <button 
                        wire:click="toggleLifeGroupStatus"
                        class="px-4 py-2 text-sm font-medium rounded-md {{ $lifeGroup->is_active ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }}"
                    >
                        {{ $lifeGroup->is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                </div>
            </div>

            <!-- Success Message -->
            @if (session()->has('message'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-blue-600">Total Members</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $members->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-green-600">Active Members</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $members->where('is_active', true)->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-purple-600">Average Age</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $members->count() > 0 ? round($members->avg('age')) : 0 }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Members Section -->
            <div class="bg-gray-50 rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Life Group Members</h2>
                    <span class="text-sm text-gray-500">
                        {{ $members->count() }} member(s)
                    </span>
                </div>

                @if($members->count() > 0)
                    <div class="overflow-hidden shadow-md border border-grey-700 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Member
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Contact
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ministry
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ministry Assignment
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Role
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($members as $member)
                                    <tr class="hover:bg-gray-50" wire:navigate href="{{route('members.show', $member)}}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($member->member_photo)
                                                    <div class="h-10 w-10 flex-shrink-0">
                                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $member->member_photo) }}" alt="">
                                                    </div>
                                                @else
                                                    <div class="h-10 w-10 flex-shrink-0 bg-gray-200 rounded-full flex items-center justify-center">
                                                        <span class="text-gray-500 text-sm font-medium">
                                                            {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                @endif
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $member->first_name }} {{ $member->last_name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $member->age }} years old
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $member->contact }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $member->ministry }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $member->ministry_assignment }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $member->status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $member->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $member->member_role }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No members yet</h3>
                        <p class="mt-2 text-gray-500">This life group doesn't have any members assigned to it.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>