<div>
    @php
        $notifications = auth()->user()->notifications()->orderBy('created_at', 'desc')->take(5)->get();
        $unreadCount = auth()->user()->notifications()->where('read', false)->count();
    @endphp

    <div class="p-4 bg-white dark:bg-zinc-900">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-medium text-zinc-900 dark:text-white">
                @if ($unreadCount > 0)
                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100">
                        {{ $unreadCount }}
                    </span>
                @endif
            </h2>

            @if ($unreadCount > 0)
                <button
                    wire:click="markAllAsRead"
                    class="text-xs font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
                >
                    Mark all as read
                </button>
            @endif
        </div>

        <div class="space-y-2">
            @forelse ($notifications as $notification)
                <div class="bg-white dark:bg-zinc-800 rounded border-l-2 {{ $notification->read ? 'border-gray-200 dark:border-zinc-700' : 'border-blue-500' }} shadow-sm hover:shadow transition-shadow duration-150 flex items-center">
                    <div class="flex-1 p-3">
                        <div class="flex justify-between items-start">
                            <p class="text-sm {{ $notification->read ? 'text-gray-600 dark:text-zinc-400' : 'text-gray-800 dark:text-zinc-200 font-medium' }}">
                                {{ $notification->message }}
                            </p>
                            <span class="ml-2 text-xs text-gray-400 dark:text-zinc-500 flex-shrink-0">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </div>

                        @if ($notification->link)
                            <div class="mt-1.5">
                                <a
                                    href="{{ $notification->link }}"
                                    wire:click="markAsRead({{ $notification->id }})"
                                    class="inline-flex items-center text-xs font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
                                >
                                    View details
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>

                    @if (!$notification->read)
                        <div class="pr-3">
                            <button
                                wire:click="markAsRead({{ $notification->id }})"
                                class="text-gray-400 hover:text-blue-600 dark:text-zinc-500 dark:hover:text-blue-400 transition-colors"
                                title="Mark as read"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-8 bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-8 w-8 text-gray-300 dark:text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <p class="mt-1.5 text-sm text-gray-500 dark:text-zinc-400">No notifications</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
