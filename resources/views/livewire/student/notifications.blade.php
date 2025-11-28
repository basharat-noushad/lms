<div>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Notifications</h1>
            <p class="text-gray-500 dark:text-gray-400">Stay updated with your course progress</p>
        </div>
        <button wire:click="markAllRead" class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
            Mark all as read
        </button>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($notifications as $notification)
                <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition {{ is_null($notification->read_at) ? 'bg-blue-50 dark:bg-blue-900/10' : '' }}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center mb-1">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mr-3">
                                    {{ $notification->title }}
                                </h3>
                                @if(is_null($notification->read_at))
                                    <span class="px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        New
                                    </span>
                                @endif
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-2">{{ $notification->message }}</p>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </div>
                        @if(is_null($notification->read_at))
                            <button wire:click="markAsRead({{ $notification->id }})" class="ml-4 text-sm text-primary-600 hover:text-primary-800 dark:text-primary-400">
                                Mark as read
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No notifications</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">You're all caught up!</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
</div>
