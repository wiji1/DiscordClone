{{-- resources/views/livewire/pages/chat-rooms.blade.php --}}
<div class="h-full flex flex-col">
    <div class="flex h-full w-full flex-1 rounded-xl overflow-hidden">
        <!-- Left sidebar - Rooms list -->
        <div class="w-1/4 border-r border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-zinc-900 flex flex-col">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold dark:text-white">{{ __('Chat Rooms') }}</h2>
                <div class="flex gap-2">
                    <button
                        wire:click="$dispatch('open-custom-modal', {
                        data: {
                            modalId: 'create-room-modal',
                            title: 'Create New Room',
                            content: 'App\\\\Livewire\\\\Actions\\\\CreateRoom',
                            size: 'lg',
                            showFooter: false
                        }
                    })"
                        class="p-1 rounded-md bg-blue-500 text-white hover:bg-blue-600"
                        title="{{ __('Create Room') }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button
                        wire:click="$dispatch('open-custom-modal', {
                            data: {
                                modalId: 'join-room-modal',
                                title: 'Join Room',
                                content: 'App\\\\Livewire\\\\Actions\\\\JoinRoom',
                                size: 'lg',
                                showFooter: false
                            }
                        })"
                        class="p-1 rounded-md bg-green-500 text-white hover:bg-green-600"
                        title="{{ __('Join Room') }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.707 3.293a1 1 0 010 1.414L5.414 7H11a7 7 0 017 7v2a1 1 0 11-2 0v-2a5 5 0 00-5-5H5.414l2.293 2.293a1 1 0 11-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="space-y-2 overflow-y-auto flex-grow min-h-0">
                @forelse($roomsList as $room)
                    <div
                        wire:click="selectRoom({{ $room->id }})"
                        class="flex cursor-pointer items-center gap-3 rounded-lg p-3 transition-colors hover:bg-neutral-100 dark:hover:bg-zinc-800
                        {{ $selectedRoom && $selectedRoom->id === $room->id ? 'bg-neutral-100 dark:bg-zinc-800' : '' }}"
                    >
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white flex-shrink-0">
                            {{ substr($room->name, 0, 1) }}
                        </span>
                        <div class="flex-grow overflow-hidden">
                            <h3 class="font-medium dark:text-white truncate">{{ $room->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                @php
                                    $lastMessage = $room->messages()->latest()->first();
                                @endphp

                                @if($lastMessage)
                                    {{ \Illuminate\Support\Str::limit($lastMessage->message, 25) }}
                                @else
                                    {{ __('No messages yet') }}
                                @endif
                            </p>
                        </div>
                        @if($room->owner_id === auth()->id())
                            <div class="flex-shrink-0">
                                <span class="h-2 w-2 rounded-full bg-yellow-500" title="{{ __('Owner') }}"></span>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="rounded-lg p-4 text-center dark:text-gray-400">
                        <p>{{ __('No chat rooms yet.') }}</p>
                        <button
                            wire:click="$dispatch('open-custom-modal', {
                                data: {
                                    modalId: 'create-room-modal',
                                    title: 'Create New Room',
                                    content: 'App\\\\Livewire\\\\Actions\\\\CreateRoom',
                                    size: 'lg',
                                    showFooter: false
                                }
                            })"
                            class="mt-2 inline-block text-sm text-blue-500 hover:underline"
                        >
                            {{ __('Create your first room') }}
                        </button>
                        <p class="mt-2">{{ __('or') }}</p>
                        <button
                            wire:click="$dispatch('open-custom-modal', {
                                data: {
                                    modalId: 'join-room-modal',
                                    title: 'Join Room',
                                    content: 'App\\\\Livewire\\\\Actions\\\\JoinRoom',
                                    size: 'lg',
                                    showFooter: false
                                }
                            })"
                            class="mt-2 inline-block text-sm text-blue-500 hover:underline"
                        >
                            {{ __('Join with invite code') }}
                        </button>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="w-3/4 flex flex-col h-full bg-white dark:bg-zinc-900">
            @if($selectedRoom)
                <div class="flex-shrink-0 flex justify-between items-center border-b border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-zinc-900">
                    <div class="flex items-center">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white flex-shrink-0">
                            {{ substr($selectedRoom->name, 0, 1) }}
                        </span>
                        <div class="ml-3 overflow-hidden">
                            <h2 class="font-semibold dark:text-white truncate">{{ $selectedRoom->name }}</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $selectedRoom->description }}</p>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <button
                            wire:click="$dispatch('open-custom-modal', {
                                data: {
                                    modalId: 'room-members-modal',
                                    title: 'Room Members',
                                    content: 'App\\\\Livewire\\\\Actions\\\\RoomMembers',
                                    size: 'lg',
                                    showFooter: false,
                                    roomId: {{ $selectedRoom->id }}
                                }
                            })"
                            class="p-2 rounded-md hover:bg-neutral-100 dark:hover:bg-zinc-800 text-neutral-500"
                            title="{{ __('Members') }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                            </svg>
                        </button>
                        <button
                            wire:click="$dispatch('open-custom-modal', {
                                data: {
                                    modalId: 'room-invite-modal',
                                    title: 'Invite People',
                                    content: 'App\\\\Livewire\\\\Actions\\\\RoomInvite',
                                    size: 'lg',
                                    showFooter: false,
                                    roomId: {{ $selectedRoom->id }}
                                }
                            })"
                            class="p-2 rounded-md hover:bg-neutral-100 dark:hover:bg-zinc-800 text-neutral-500"
                            title="{{ __('Invite') }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                            </svg>
                        </button>
                        @if($selectedRoom->owner_id !== auth()->id())
                            <button
                                wire:click="leaveRoom"
                                class="p-2 rounded-md hover:bg-red-100 dark:hover:bg-red-900/20 text-red-500"
                                title="{{ __('Leave Room') }}"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V4a1 1 0 00-1-1H3zm11 3a1 1 0 11-2 0 1 1 0 012 0zm-8.707.293a1 1 0 011.414 0L10 9.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>

                <div class="h-0 flex-grow overflow-y-auto p-4" id="messages-container"
                     x-data="{}"
                     x-init="$nextTick(() => { $el.scrollTop = $el.scrollHeight; })"
                     wire:poll.1s="refreshMessages">
                    <div class="space-y-4">
                        @forelse($messages as $msg)
                            <div class="flex {{ $msg->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[75%] rounded-xl {{ $msg->user_id === auth()->id() ? 'bg-blue-500 text-white' : 'bg-neutral-100 dark:bg-zinc-800 dark:text-white' }} p-3 shadow-sm">
                                    @if($msg->user_id !== auth()->id())
                                        <p class="text-xs font-medium mb-1 {{ $msg->user_id === auth()->id() ? 'text-blue-200' : 'text-gray-500 dark:text-gray-400' }}">
                                            {{ $msg->user->username }}
                                        </p>
                                    @endif
                                    <p class="break-words">{{ $msg->message }}</p>
                                    <p class="mt-1 text-xs text-right {{ $msg->user_id === auth()->id() ? 'text-blue-200' : 'text-gray-500 dark:text-gray-400' }}">
                                        {{ $msg->created_at->format('g:i A') }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="flex h-full items-center justify-center">
                                <p class="text-center text-gray-500 dark:text-gray-400">{{ __('No messages yet. Start a conversation!') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="flex-shrink-0 border-t border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-zinc-900">
                    <form wire:submit.prevent="sendMessage" class="flex gap-2">
                        <input
                            type="text"
                            wire:model="message"
                            class="flex-1 rounded-lg border border-neutral-300 px-4 py-2 focus:border-blue-500 focus:outline-none dark:border-neutral-600 dark:bg-zinc-800 dark:text-white"
                            placeholder="{{ __('Type a message...') }}"
                            autocomplete="off"
                            wire:keydown.enter="sendMessage"
                        >
                        <button
                            type="submit"
                            class="rounded-lg bg-blue-500 px-4 py-2 font-medium text-white hover:bg-blue-600 focus:outline-none disabled:opacity-50 transition-opacity"
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-50"
                            wire:target="sendMessage"
                        >
                            {{ __('Send') }}
                        </button>
                    </form>
                </div>
            @else
                <div class="flex h-full items-center justify-center">
                    <div class="text-center">
                        <p class="text-xl font-semibold dark:text-white">{{ __('Select a room to start chatting') }}</p>
                        <p class="mt-2 text-gray-500 dark:text-gray-400">{{ __('Choose from your rooms list or create/join a new room') }}</p>
                        <div class="mt-4 flex justify-center gap-4">
                            <button
                                wire:click="$dispatch('open-custom-modal', {
                                    data: {
                                        modalId: 'create-room-modal',
                                        title: 'Create New Room',
                                        content: 'App\\\\Livewire\\\\Actions\\\\CreateRoom',
                                        size: 'lg',
                                        showFooter: false
                                    }
                                })"
                                class="inline-block rounded-lg bg-blue-500 px-4 py-2 font-medium text-white hover:bg-blue-600"
                            >
                                {{ __('Create Room') }}
                            </button>
                            <button
                                wire:click="$dispatch('open-custom-modal', {
                                    data: {
                                        modalId: 'join-room-modal',
                                        title: 'Join Room',
                                        content: 'App\\\\Livewire\\\\Actions\\\\JoinRoom',
                                        size: 'lg',
                                        showFooter: false
                                    }
                                })"
                                class="inline-block rounded-lg bg-green-500 px-4 py-2 font-medium text-white hover:bg-green-600"
                            >
                                {{ __('Join Room') }}
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            function copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(() => {
                    const toast = document.getElementById('copy-toast');
                    toast.classList.remove('hidden');
                    requestAnimationFrame(() => {
                        toast.classList.add('opacity-100');
                        toast.classList.remove('opacity-0');
                    });

                    setTimeout(() => {
                        toast.classList.add('opacity-0');
                        toast.classList.remove('opacity-100');
                        setTimeout(() => toast.classList.add('hidden'), 500);
                    }, 2000);
                });
            }
        </script>
        <script>
            document.addEventListener('livewire:initialized', () => {
                console.log('Refresh listener added');

                Livewire.on('refreshView', () => {
                    location.reload();
                });

            });
        </script>
        <script>
            document.addEventListener('livewire:init', function() {
                const messagesContainer = document.getElementById('messages-container');

                const scrollToBottom = () => {
                    if (messagesContainer) {
                        setTimeout(() => {
                            messagesContainer.scrollTop = messagesContainer.scrollHeight;
                        }, 50);
                    }
                };

                if (messagesContainer) {
                    scrollToBottom();
                }

                Livewire.on('messagesRefreshed', ({ hasNewMessages }) => {
                    if (hasNewMessages) {
                        scrollToBottom();
                    }
                });

                Livewire.on('messageSent', ({ shouldScroll }) => {
                    if (shouldScroll) {
                        scrollToBottom();
                    }
                });

                Livewire.on('roomSelected', () => {
                    scrollToBottom();
                });

                Livewire.hook('morph.updated', ({ el, component }) => {
                    if (el.id === 'messages-container' || el.querySelector('#messages-container')) {
                        const isNearBottom = messagesContainer &&
                            (messagesContainer.scrollHeight - messagesContainer.scrollTop - messagesContainer.clientHeight < 100);

                        if (isNearBottom) {
                            scrollToBottom();
                        }
                    }
                });
            });
        </script>
    @endpush
</div>
