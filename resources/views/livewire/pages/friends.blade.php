<div :title="__('Friends')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl p-4">
        <!-- Friend Requests Section -->
        <div class="w-full">
            <h2 class="mb-3 text-xl font-bold dark:text-white">{{ __('Friend Requests') }}</h2>
            <div class="grid gap-4 md:grid-cols-3">
                @forelse(auth()->user()->getFriendRequests() as $request)
                    <div class="flex flex-col rounded-xl border border-neutral-200 bg-white p-4 shadow-sm dark:border-neutral-700 dark:bg-zinc-900">
                        <div class="flex items-center gap-3">
                            <span class="flex h-12 w-12 items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                {{ $request->sender->initials() }}
                            </span>
                            <div class="flex-grow">
                                <h3 class="font-semibold dark:text-white">{{ $request->sender->username }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $request->sender->email }}</p>
                            </div>
                        </div>
                        <div class="mt-4 flex gap-2">
                            <button
                                class="flex-1 rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-50 dark:border-neutral-600 dark:bg-zinc-800 dark:text-neutral-200 dark:hover:bg-zinc-700"
                                wire:click="acceptFriendRequest('{{ $request->sender->username }}')"
                            >
                                {{ __('Accept') }}
                            </button>
                            <button
                                class="flex-1 rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-50 dark:border-neutral-600 dark:bg-zinc-800 dark:text-neutral-200 dark:hover:bg-zinc-700"
                                wire:click="rejectFriendRequest('{{ $request->sender->username }}')"
                            >
                                {{ __('Decline') }}
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 rounded-xl border border-neutral-200 bg-white p-6 text-center dark:border-neutral-700 dark:bg-zinc-900">
                        <p class="text-gray-500 dark:text-gray-400">{{ __('No pending friend requests at the moment.') }}</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Friends Section -->
        <div class="mt-6 w-full">
            <h2 class="mb-3 text-xl font-bold dark:text-white">{{ __('Your Friends') }}</h2>
            <div class="grid gap-4 md:grid-cols-3">
                @forelse(auth()->user()->getFriends() as $friend)
                    <div class="flex flex-col rounded-xl border border-neutral-200 bg-white p-4 shadow-sm dark:border-neutral-700 dark:bg-zinc-900">
                        <div class="flex items-center gap-3">
                            <span class="flex h-12 w-12 items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                {{ $friend->initials() }}
                            </span>
                            <div class="flex-grow">
                                <h3 class="font-semibold dark:text-white">{{ $friend->username }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $friend->email }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="h-3 w-3 rounded-full bg-green-500" title="{{ __('Online') }}"></div>
                            </div>
                        </div>
                        <div class="mt-4 flex gap-2">
                            <button
                                class="flex-1 rounded-lg bg-zinc-100 px-3 py-2 text-sm font-medium text-zinc-800 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700"
                                wire:click="startChat({{ $friend->id }})"
                            >
                                <div class="flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                                    </svg>
                                    {{ __('Message') }}
                                </div>
                            </button>
                            <button
                                class="rounded-lg border border-neutral-300 px-3 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-50 dark:border-neutral-600 dark:text-neutral-200 dark:hover:bg-zinc-700"
                                wire:click="$dispatch('open-custom-modal', {
                                    data: {
                                        modalId: 'friend-options-modal',
                                        title: 'Friend Options',
                                        content: 'App\\Livewire\\Actions\\FriendOptions',
                                        friendId: {{ $friend->id }},
                                        size: 'sm',
                                        showFooter: false,
                                    }
                                })"
                                wire:target="openModal"
                                wire:loading.attr="disabled"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 rounded-xl border border-neutral-200 bg-white p-6 text-center dark:border-neutral-700 dark:bg-zinc-900">
                        <p class="text-gray-500 dark:text-gray-400">{{ __('You don\'t have any friends added yet.') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @livewireStyles
    @livewireScripts
</div>
