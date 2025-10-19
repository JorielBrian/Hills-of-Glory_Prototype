<div>
    <!-- Header Section -->
    <div class="mb-6 bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Events & Attendance</h2>
                <p class="text-gray-600 mt-1">Manage church events and track member attendance</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('events.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add New Event
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="mb-6 bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0">
            <div class="flex-1">
                <input type="text" 
                       wire:model.debounce.300ms="search"
                       placeholder="Search events by title, location, or description..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex items-center space-x-4">
                <select wire:model="perPage" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="10">10 per page</option>
                    <option value="25">25 per page</option>
                    <option value="50">50 per page</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Events Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th wire:click="sortBy('title')" 
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                            <div class="flex items-center">
                                Event Title
                                @if($sortField === 'title')
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"></path>
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th wire:click="sortBy('event_date')" 
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                            <div class="flex items-center">
                                Date
                                @if($sortField === 'event_date')
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"></path>
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Attendance
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($events as $event)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $event->title }}
                                        </div>
                                        @if($event->location)
                                            <div class="text-sm text-gray-500">
                                                {{ $event->location }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $event->event_date->format('M j, Y') }}
                                </div>
                                @if($event->start_time)
                                    <div class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $event->type === 'sunday_service' ? 'bg-blue-100 text-blue-800' : 
                                       ($event->type === 'wednesday_service' ? 'bg-green-100 text-green-800' : 
                                       ($event->type === 'friday_service' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800')) }}">
                                    {{ str($event->type)->replace('_', ' ')->title() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <span class="font-semibold">{{ $event->present_count }}</span> 
                                    <span class="text-gray-500">/ {{ $totalMembers }} members</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                    @php
                                        $percentage = $totalMembers > 0 ? ($event->present_count / $totalMembers) * 100 : 0;
                                    @endphp
                                    <div class="bg-green-600 h-2 rounded-full" 
                                         style="width: {{ $percentage }}%"></div>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ number_format($percentage, 1) }}% attendance
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <button wire:click="showAttendance({{ $event->id }})"
                                            class="text-blue-600 hover:text-blue-900 transition-colors duration-150"
                                            title="Manage Attendance">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                                    <a href="{{ route('events.edit', $event->id) }}"
                                       class="text-indigo-600 hover:text-indigo-900 transition-colors duration-150"
                                       title="Edit Event">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <button wire:click="deleteEvent({{ $event->id }})"
                                            wire:confirm="Are you sure you want to delete this event?"
                                            class="text-red-600 hover:text-red-900 transition-colors duration-150"
                                            title="Delete Event">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="mt-4 text-lg font-medium text-gray-900">No events found</p>
                                <p class="mt-2">Get started by creating your first event.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($events->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $events->links() }}
            </div>
        @endif
    </div>

    <!-- Attendance Modal -->
    @if($showAttendanceModal && $selectedEvent)
        <div class="fixed inset-0 overflow-y-auto z-50">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-7xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-2xl leading-6 font-bold text-gray-900 mb-2">
                                    Attendance: {{ $selectedEvent->title }}
                                </h3>
                                <p class="text-sm text-gray-500 mb-6">
                                    {{ $selectedEvent->event_date->format('F j, Y') }} • {{ $selectedEvent->location }}
                                </p>

                                <!-- Bulk Actions -->
                                <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-semibold text-blue-900">Quick Actions</h4>
                                            <p class="text-sm text-blue-700">Mark multiple members at once</p>
                                        </div>
                                        <div class="flex space-x-3">
                                            <button wire:click="markAllPresent"
                                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-150 text-sm font-medium">
                                                Mark All Present
                                            </button>
                                            <button wire:click="updateBulkAttendance"
                                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-150 text-sm font-medium">
                                                Save Bulk Changes
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Attendance Table -->
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    <div class="flex items-center">
                                                        <input type="checkbox" 
                                                               wire:model="bulkAttendanceAll"
                                                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                        <span class="ml-2">Member</span>
                                                    </div>
                                                </th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Status
                                                </th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Ministry
                                                </th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Actions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach(Member::where('isActive', true)->get() as $member)
                                                <tr>
                                                    <td class="px-4 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <input type="checkbox" 
                                                                   wire:model="bulkAttendance.{{ $member->id }}"
                                                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    {{ $member->first_name }} {{ $member->last_name }}
                                                                </div>
                                                                <div class="text-sm text-gray-500">
                                                                    {{ $member->church_role->value }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-4 whitespace-nowrap">
                                                        <select wire:model="attendanceData.{{ $member->id }}.status"
                                                                wire:change="updateAttendance({{ $member->id }})"
                                                                class="text-sm border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                                                            <option value="present">Present</option>
                                                            <option value="absent">Absent</option>
                                                            <option value="late">Late</option>
                                                            <option value="excused">Excused</option>
                                                        </select>
                                                    </td>
                                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $member->ministry?->value ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                                                        <div class="flex items-center space-x-2">
                                                            <input type="checkbox" 
                                                                   wire:model="attendanceData.{{ $member->id }}.volunteered"
                                                                   wire:change="updateAttendance({{ $member->id }})"
                                                                   id="volunteer-{{ $member->id }}"
                                                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                            <label for="volunteer-{{ $member->id }}" class="text-sm text-gray-600">Volunteer</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" 
                                wire:click="$set('showAttendanceModal', false)"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>