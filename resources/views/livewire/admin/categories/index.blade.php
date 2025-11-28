<div>
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Categories</h2>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Category
        </a>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-400 text-green-700 dark:text-green-400 rounded">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-400 text-red-700 dark:text-red-400 rounded">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
        <div class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($categories as $category)
                <!-- Parent Category -->
                <div class="bg-gray-50 dark:bg-gray-800/50 p-4 flex items-center justify-between group hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 h-10 w-10 bg-white dark:bg-gray-700 rounded-lg flex items-center justify-center border border-gray-200 dark:border-gray-600">
                            @if($category->icon)
                                <img src="{{ Storage::url($category->icon) }}" class="h-6 w-6 object-contain">
                            @else
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ $category->name }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $category->slug }} • {{ $category->courses_count ?? 0 }} courses</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <button wire:click="toggleStatus({{ $category->id }})" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 {{ $category->is_active ? 'bg-primary-600' : 'bg-gray-200 dark:bg-gray-700' }}">
                            <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $category->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                        </button>
                        
                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-gray-400 hover:text-primary-600 dark:hover:text-primary-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        
                        <button wire:click="deleteCategory({{ $category->id }})" wire:confirm="Are you sure? This will delete the category." class="text-gray-400 hover:text-red-600 dark:hover:text-red-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Subcategories -->
                @if($category->subcategories->count() > 0)
                    <div class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700/50">
                        @foreach($category->subcategories as $sub)
                            <div class="pl-16 pr-4 py-3 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0 h-8 w-8 bg-gray-100 dark:bg-gray-700 rounded flex items-center justify-center">
                                        @if($sub->icon)
                                            <img src="{{ Storage::url($sub->icon) }}" class="h-4 w-4 object-contain">
                                        @else
                                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $sub->name }}</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $sub->slug }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-3">
                                    <button wire:click="toggleStatus({{ $sub->id }})" class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 {{ $sub->is_active ? 'bg-primary-600' : 'bg-gray-200 dark:bg-gray-700' }}">
                                        <span class="inline-block h-3 w-3 transform rounded-full bg-white transition-transform {{ $sub->is_active ? 'translate-x-5' : 'translate-x-1' }}"></span>
                                    </button>

                                    <a href="{{ route('admin.categories.edit', $sub) }}" class="text-gray-400 hover:text-primary-600 dark:hover:text-primary-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    <button wire:click="deleteCategory({{ $sub->id }})" wire:confirm="Are you sure?" class="text-gray-400 hover:text-red-600 dark:hover:text-red-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @empty
                <div class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No categories found</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
