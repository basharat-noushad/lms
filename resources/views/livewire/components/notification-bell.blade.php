<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="relative p-2 text-gray-400 hover:text-gray-500 focus:outline-none">
        <span class="sr-only">View notifications</span>
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
        @endif
    </button>

    <div x-show="open" 
         @click.away="open = false"
         class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
         style="display: none;">
        <div class="py-1">
            <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-sm font-medium text-gray-900 dark:text-white">Notifications</h3>
                @if($unreadCount > 0)
                    <button wire:click="markAllRead" class="text-xs text-primary-600 hover:text-primary-800 dark:text-primary-400">
                        Mark all read
                    </button>
                @endif
            </div>

            <div class="max-h-64 overflow-y-auto">
                @forelse($notifications as $notification)
                    <button wire:click="markAsRead({{ $notification->id }})" class="w-full text-left px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition {{ is_null($notification->read_at) ? 'bg-blue-50 dark:bg-blue-900/10' : '' }}">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $notification->title }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ $notification->message }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                    </button>
                @empty
                    <div class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                        No notifications
                    </div>
                @endforelse
            </div>

            <div class="border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('student.notifications') }}" class="block px-4 py-2 text-sm text-center text-primary-600 hover:text-primary-800 dark:text-primary-400 font-medium">
                    View all notifications
                </a>
            </div>
        </div>
    </div>
</div>
