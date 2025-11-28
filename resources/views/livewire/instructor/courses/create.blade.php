<div>
    @section('header', 'Create New Course')

    <div class="max-w-4xl mx-auto">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-2">
                @foreach(range(1, $totalSteps) as $step)
                    <div class="flex flex-col items-center w-full {{ $step !== $totalSteps ? 'border-r border-gray-200 dark:border-gray-700' : '' }}">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full {{ $currentStep >= $step ? 'bg-primary-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400' }} font-bold text-sm mb-1">
                            {{ $step }}
                        </div>
                        <span class="text-xs {{ $currentStep >= $step ? 'text-primary-600 font-medium' : 'text-gray-500 dark:text-gray-400' }}">
                            @if($step == 1) Basic Info
                            @elseif($step == 2) Details
                            @elseif($step == 3) Media
                            @elseif($step == 4) Pricing
                            @endif
                        </span>
                    </div>
                @endforeach
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                <div class="bg-primary-600 h-2.5 rounded-full transition-all duration-300" style="width: {{ ($currentStep / $totalSteps) * 100 }}%"></div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8">
            <form wire:submit.prevent="save">
                <!-- Step 1: Basic Info -->
                @if($currentStep === 1)
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Basic Information</h3>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Course Title</label>
                            <input type="text" wire:model.live="title" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white" placeholder="e.g. Master Laravel 11">
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
                @endif

                <!-- Step 2: Details -->
                @if($currentStep === 2)
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Course Details</h3>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                            <textarea wire:model="description" rows="5" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white" placeholder="Detailed description of your course..."></textarea>
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Requirements (One per line)</label>
                            <textarea wire:model="requirements" rows="3" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white" placeholder="Basic PHP knowledge&#10;Computer with internet access"></textarea>
                            @error('requirements') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">What will students learn? (One per line)</label>
                            <textarea wire:model="outcomes" rows="3" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white" placeholder="Build a complete application&#10;Master advanced concepts"></textarea>
                            @error('outcomes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @endif

                <!-- Step 3: Media -->
                @if($currentStep === 3)
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Media</h3>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Course Thumbnail</label>
                            <div class="flex items-center justify-center w-full">
                                <label class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        @if($thumbnail)
                                            <img src="{{ $thumbnail->temporaryUrl() }}" class="h-48 object-contain">
                                        @else
                                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 2MB)</p>
                                        @endif
                                    </div>
                                    <input type="file" wire:model="thumbnail" class="hidden" />
                                </label>
                            </div>
                            @error('thumbnail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Trailer URL (YouTube/Vimeo)</label>
                            <input type="url" wire:model="trailer_url" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white" placeholder="https://youtube.com/watch?v=...">
                            @error('trailer_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @endif

                <!-- Step 4: Pricing -->
                @if($currentStep === 4)
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Pricing</h3>
                        
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
                @endif

                <!-- Navigation Buttons -->
                <div class="flex justify-between mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    @if($currentStep > 1)
                        <button type="button" wire:click="prevStep" class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            Back
                        </button>
                    @else
                        <div></div>
                    @endif

                    @if($currentStep < $totalSteps)
                        <button type="button" wire:click="nextStep" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition">
                            Next Step
                        </button>
                    @else
                        <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                            Create Course
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
