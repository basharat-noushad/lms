<div>
    @section('header', 'Edit Course')

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">{{ $course->title }}</h2>
        <div class="flex space-x-3">
            <a href="{{ route('instructor.courses.curriculum', $course) }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200 rounded-lg transition">
                Manage Curriculum
            </a>
            <a href="{{ route('instructor.courses.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                Back to Courses
            </a>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-400 text-green-700 dark:text-green-400 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
        <div class="flex border-b border-gray-200 dark:border-gray-700">
            <button wire:click="$set('activeTab', 'basic')" class="px-6 py-4 text-sm font-medium {{ $activeTab === 'basic' ? 'text-primary-600 border-b-2 border-primary-600' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                Basic Information
            </button>
            <button wire:click="$set('activeTab', 'details')" class="px-6 py-4 text-sm font-medium {{ $activeTab === 'details' ? 'text-primary-600 border-b-2 border-primary-600' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                Details
            </button>
            <button wire:click="$set('activeTab', 'media')" class="px-6 py-4 text-sm font-medium {{ $activeTab === 'media' ? 'text-primary-600 border-b-2 border-primary-600' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                Media
            </button>
            <button wire:click="$set('activeTab', 'pricing')" class="px-6 py-4 text-sm font-medium {{ $activeTab === 'pricing' ? 'text-primary-600 border-b-2 border-primary-600' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                Pricing
            </button>
        </div>

        <div class="p-6">
            <form wire:submit.prevent="save">
                <!-- Basic Info Tab -->
                <div x-show="$wire.activeTab === 'basic'" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Course Title</label>
                        <input type="text" wire:model.live="title" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Slug</label>
                        <input type="text" wire:model="slug" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white bg-gray-50 dark:bg-gray-800" readonly>
                        @error('slug') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                            <select wire:model="category_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" class="font-bold">{{ $category->name }}</option>
                                    @foreach($category->children as $child)
                                        <option value="{{ $child->id }}">-- {{ $child->name }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Level</label>
                            <select wire:model="level" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                                <option value="beginner">Beginner</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="advanced">Advanced</option>
                            </select>
                            @error('level') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Details Tab -->
                <div x-show="$wire.activeTab === 'details'" class="space-y-6" style="display: none;">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                        <textarea wire:model="description" rows="5" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white"></textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Requirements (One per line)</label>
                        <textarea wire:model="requirements" rows="3" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white"></textarea>
                        @error('requirements') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">What will students learn? (One per line)</label>
                        <textarea wire:model="outcomes" rows="3" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white"></textarea>
                        @error('outcomes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Media Tab -->
                <div x-show="$wire.activeTab === 'media'" class="space-y-6" style="display: none;">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Course Thumbnail</label>
                        <div class="flex items-start space-x-4">
                            @if($thumbnail && !$newThumbnail)
                                <img src="{{ Storage::url($thumbnail) }}" class="h-32 w-48 object-cover rounded-lg">
                            @elseif($newThumbnail)
                                <img src="{{ $newThumbnail->temporaryUrl() }}" class="h-32 w-48 object-cover rounded-lg">
                            @endif
                            
                            <div class="flex-1">
                                <input type="file" wire:model="newThumbnail" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 2MB)</p>
                            </div>
                        </div>
                        @error('newThumbnail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Trailer URL</label>
                        <input type="url" wire:model="trailer_url" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                        @error('trailer_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Pricing Tab -->
                <div x-show="$wire.activeTab === 'pricing'" class="space-y-6" style="display: none;">
                    <div class="flex items-center mb-4">
                        <input type="checkbox" wire:model.live="is_free" id="is_free" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <label for="is_free" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                            This is a free course
                        </label>
                    </div>

                    @if(!$is_free)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price ($)</label>
                            <input type="number" wire:model="price" step="0.01" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    @endif
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition">
                        Update Course
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
