<div>
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Categories
        </a>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mt-4">{{ $category ? 'Edit Category' : 'Create Category' }}</h2>
    </div>

    <form wire:submit="save" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name *</label>
                <input type="text" id="name" wire:model.live="name" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white @error('name') border-red-500 @enderror">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Slug -->
            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Slug *</label>
                <input type="text" id="slug" wire:model="slug" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white @error('slug') border-red-500 @enderror">
                @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Parent Category -->
            <div>
                <label for="parent_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Parent Category</label>
                <select id="parent_id" wire:model="parent_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                    <option value="">None (Top Level)</option>
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                    @endforeach
                </select>
                @error('parent_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Sort Order -->
            <div>
                <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sort Order</label>
                <input type="number" id="sort_order" wire:model="sort_order" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
            </div>

            <!-- Description -->
            <div class="lg:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                <textarea id="description" wire:model="description" rows="3" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white"></textarea>
            </div>

            <!-- Icon -->
            <div>
                <label for="icon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Icon (Small)</label>
                <input type="file" id="icon" wire:model="icon" accept="image/*" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                @error('icon') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                
                <div class="mt-2 flex items-center space-x-4">
                    @if ($icon)
                        <img src="{{ $icon->temporaryUrl() }}" class="h-10 w-10 object-contain bg-gray-100 rounded p-1">
                        <span class="text-xs text-gray-500">New</span>
                    @elseif ($current_icon)
                        <img src="{{ Storage::url($current_icon) }}" class="h-10 w-10 object-contain bg-gray-100 rounded p-1">
                        <span class="text-xs text-gray-500">Current</span>
                    @endif
                </div>
            </div>

            <!-- Image -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cover Image</label>
                <input type="file" id="image" wire:model="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

                <div class="mt-2">
                    @if ($image)
                        <img src="{{ $image->temporaryUrl() }}" class="h-32 w-full object-cover rounded-lg">
                        <span class="text-xs text-gray-500">New</span>
                    @elseif ($current_image)
                        <img src="{{ Storage::url($current_image) }}" class="h-32 w-full object-cover rounded-lg">
                        <span class="text-xs text-gray-500">Current</span>
                    @endif
                </div>
            </div>

            <!-- Status -->
            <div class="lg:col-span-2">
                <label class="flex items-center">
                    <input type="checkbox" wire:model="is_active" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Active</span>
                </label>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-6 flex items-center justify-end space-x-4">
            <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 rounded-lg transition">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition">
                {{ $category ? 'Update Category' : 'Create Category' }}
            </button>
        </div>
    </form>
</div>
