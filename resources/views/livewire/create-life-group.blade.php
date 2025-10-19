<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl text-black p-6">
        <div class="bg-white rounded-lg shadow-sm p-6 max-w-2xl mx-auto w-full">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Create New Life Group</h1>
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

            <form wire:submit.prevent="save" class="space-y-6" enctype="multipart/form-data">
                <!-- Life Group Information -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Life Group Information</h2>
                    
                    <!-- Life Group Name -->
                    <div class="mb-4">
                        <label for="life_group_name" class="block text-sm font-medium text-gray-700">Life Group Name *</label>
                        <input type="text" wire:model="life_group_name" id="life_group_name" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter life group name">
                        @error('life_group_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Life Group Photo -->
                    <div class="mb-4">
                        <label for="life_group_photo" class="block text-sm font-medium text-gray-700">Life Group Photo</label>
                        <input type="file" wire:model="life_group_photo" id="life_group_photo" accept="image/*"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('life_group_photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        <p class="mt-1 text-sm text-gray-500">Upload a photo for the life group (optional, max 2MB)</p>
                    </div>

                    <!-- Photo Preview -->
                    @if ($life_group_photo)
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Photo Preview</label>
                            <div class="border border-gray-300 rounded-md p-4 bg-white">
                                <img src="{{ $life_group_photo->temporaryUrl() }}" 
                                     alt="Life group photo preview" 
                                     class="max-w-full h-auto max-h-48 mx-auto rounded-lg">
                                <p class="text-xs text-gray-500 text-center mt-2">Live preview of the photo</p>
                            </div>
                        </div>
                    @endif

                    <!-- Network Leader Info (Read-only) -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Network Leader</label>
                        <div class="mt-1 p-3 bg-white border border-gray-300 rounded-md">
                            <p class="text-sm text-gray-900">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                            <p class="text-xs text-gray-500">This will be automatically set to your account</p>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-6">
                    <a href="{{ route('lifegroups') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        Back to Life Groups
                    </a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Create Life Group
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>