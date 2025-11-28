<div>
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Users
        </a>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mt-4">Edit User</h2>
    </div>

    <form wire:submit="save" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name *</label>
                <input type="text" id="name" wire:model="name" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white @error('name') border-red-500 @enderror">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
                <input type="email" id="email" wire:model="email" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white @error('email') border-red-500 @enderror">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Password (Optional) -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Password (optional)</label>
                <input type="password" id="password" wire:model="password" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white @error('password') border-red-500 @enderror">
                @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Password Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm New Password</label>
                <input type="password" id="password_confirmation" wire:model="password_confirmation" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role *</label>
                <select id="role" wire:model="role" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white @error('role') border-red-500 @enderror">
                    <option value="student">Student</option>
                    <option value="instructor">Instructor</option>
                    <option value="admin">Admin</option>
                </select>
                @error('role') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Avatar -->
            <div>
                <label for="avatar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Avatar</label>
                <input type="file" id="avatar" wire:model="avatar" accept="image/*" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white @error('avatar') border-red-500 @enderror">
                @error('avatar') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                
                <div class="mt-2 flex items-center space-x-4">
                    @if ($avatar)
                        <img src="{{ $avatar->temporaryUrl() }}" class="h-20 w-20 rounded-full object-cover">
                        <span class="text-sm text-gray-500">New avatar</span>
                    @elseif ($current_avatar)
                        <img src="{{ Storage::url($current_avatar) }}" class="h-20 w-20 rounded-full object-cover">
                        <span class="text-sm text-gray-500">Current avatar</span>
                    @else
                        <div class="h-20 w-20 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                            <span class="text-gray-400 text-2xl">{{ substr($name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Headline -->
            <div class="lg:col-span-2">
                <label for="headline" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Headline</label>
                <input type="text" id="headline" wire:model="headline" placeholder="e.g., Full Stack Developer" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
            </div>

            <!-- Bio -->
            <div class="lg:col-span-2">
                <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bio</label>
                <textarea id="bio" wire:model="bio" rows="4" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white"></textarea>
            </div>

            <!-- Social Links -->
            <div>
                <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Website</label>
                <input type="url" id="website" wire:model="website" placeholder="https://example.com" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                @error('website') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="twitter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Twitter</label>
                <input type="url" id="twitter" wire:model="twitter" placeholder="https://twitter.com/username" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
            </div>

            <div>
                <label for="linkedin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">LinkedIn</label>
                <input type="url" id="linkedin" wire:model="linkedin" placeholder="https://linkedin.com/in/username" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
            </div>

            <div>
                <label for="youtube" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">YouTube</label>
                <input type="url" id="youtube" wire:model="youtube" placeholder="https://youtube.com/@username" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
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
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 rounded-lg transition">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition">
                Update User
            </button>
        </div>
    </form>
</div>
