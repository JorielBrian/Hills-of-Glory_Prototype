<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Create New Event</h1>
                    <p class="mt-2 text-sm text-gray-600">Add a new church event or service</p>
                </div>
                <button wire:click="cancel" 
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancel
                </button>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <form wire:submit.prevent="save">
                <div class="px-6 py-6 space-y-6">
                    <!-- Flash Messages -->
                    @if (session()->has('success'))
                        <div class="rounded-md bg-green-50 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="rounded-md bg-red-50 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Event Title -->
                        <div class="sm:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700">Event Title *</label>
                            <input type="text" 
                                   wire:model="title" 
                                   id="title"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('title') border-red-300 @enderror"
                                   placeholder="e.g., Sunday Worship Service">
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="sm:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea wire:model="description" 
                                      id="description" 
                                      rows="3"
                                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                      placeholder="Brief description of the event..."></textarea>
                        </div>

                        <!-- Event Date -->
                        <div>
                            <label for="event_date" class="block text-sm font-medium text-gray-700">Event Date *</label>
                            <input type="date" 
                                   wire:model="event_date" 
                                   id="event_date"
                                   min="{{ now()->format('Y-m-d') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('event_date') border-red-300 @enderror">
                            @error('event_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Event Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Event Type *</label>
                            <select wire:model="type" 
                                    id="type"
                                    class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('type') border-red-300 @enderror">
                                <option value="">Select Event Type</option>
                                @foreach($eventTypes as $typeValue)
                                    <option value="{{ $typeValue }}">{{ str($typeValue)->replace('_', ' ')->title() }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Start Time -->
                        <div>
                            <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                            <input type="time" 
                                   wire:model="start_time" 
                                   id="start_time"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('start_time') border-red-300 @enderror">
                            @error('start_time')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- End Time -->
                        <div>
                            <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                            <input type="time" 
                                   wire:model="end_time" 
                                   id="end_time"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('end_time') border-red-300 @enderror">
                            @error('end_time')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div class="sm:col-span-2">
                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" 
                                   wire:model="location" 
                                   id="location"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   placeholder="e.g., Main Sanctuary, Fellowship Hall">
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select wire:model="status" 
                                    id="status"
                                    class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @foreach($eventStatuses as $statusValue)
                                    <option value="{{ $statusValue }}">{{ str($statusValue)->title() }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Expected Attendance -->
                        <div>
                            <label for="expected_attendance" class="block text-sm font-medium text-gray-700">Expected Attendance</label>
                            <input type="number" 
                                   wire:model="expected_attendance" 
                                   id="expected_attendance"
                                   min="1"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   placeholder="e.g., 150">
                        </div>

                        <!-- Additional Options -->
                        <div class="sm:col-span-2">
                            <div class="flex items-center">
                                <input wire:model="requires_attendance" 
                                       id="requires_attendance" 
                                       type="checkbox"
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="requires_attendance" class="ml-2 block text-sm text-gray-900">
                                    Require attendance tracking for this event
                                </label>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">If checked, you'll be able to track member attendance for this event.</p>
                        </div>

                        <!-- Notes -->
                        <div class="sm:col-span-2">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Additional Notes</label>
                            <textarea wire:model="notes" 
                                      id="notes" 
                                      rows="3"
                                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                      placeholder="Any additional information about the event..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="button" 
                            wire:click="cancel"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Create Event
                    </button>
                </div>
            </form>
        </div>

        <!-- Quick Tips -->
        <div class="mt-8 bg-blue-50 rounded-lg p-6">
            <h3 class="text-lg font-medium text-blue-900 mb-2">Quick Tips</h3>
            <ul class="text-sm text-blue-700 space-y-1">
                <li>• Use descriptive titles that members will recognize</li>
                <li>• Set accurate times to help with scheduling</li>
                <li>• Choose the appropriate event type for better organization</li>
                <li>• Enable attendance tracking for services and important events</li>
            </ul>
        </div>
    </div>
</div>