<div>
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Settings</h2>
        <button wire:click="save" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
            </svg>
            Save Changes
        </button>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-400 text-green-700 dark:text-green-400 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
        <div class="flex border-b border-gray-200 dark:border-gray-700">
            @foreach(['general', 'payment', 'features', 'seo', 'social'] as $tab)
                <button wire:click="$set('activeTab', '{{ $tab }}')" 
                        class="px-6 py-4 text-sm font-medium focus:outline-none transition-colors border-b-2 
                        {{ $activeTab === $tab 
                            ? 'border-primary-600 text-primary-600 dark:text-primary-400' 
                            : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    {{ ucfirst($tab) }}
                </button>
            @endforeach
        </div>

        <div class="p-6">
            @foreach($settings as $group => $groupSettings)
                <div x-show="$wire.activeTab === '{{ $group }}'" class="space-y-6">
                    @foreach($groupSettings as $key => $setting)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ ucwords(str_replace('_', ' ', $key)) }}
                            </label>

                            @if($setting['type'] === 'boolean')
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="settings.{{ $group }}.{{ $key }}.value" class="sr-only peer" value="true">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Enabled</span>
                                </label>
                            @elseif($setting['type'] === 'file')
                                <input type="file" wire:model="uploads.{{ $key }}" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                                @if(isset($setting['value']) && $setting['value'])
                                    <div class="mt-2">
                                        <img src="{{ Storage::url($setting['value']) }}" class="h-10 object-contain bg-gray-100 rounded p-1">
                                    </div>
                                @endif
                            @elseif($setting['type'] === 'number')
                                <input type="number" wire:model="settings.{{ $group }}.{{ $key }}.value" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                            @else
                                <input type="text" wire:model="settings.{{ $group }}.{{ $key }}.value" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>
