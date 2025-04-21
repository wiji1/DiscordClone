@php use App\Models\Chat; @endphp
<div class="h-full flex flex-col">
    <div class="flex h-full w-full flex-1 rounded-xl overflow-hidden">
        <!-- Left sidebar - Friends list -->
        <div class="w-1/4 border-r border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-zinc-900 flex flex-col">
            <h2 class="flex-shrink-0 mb-4 text-xl font-bold dark:text-white">{{ __('Conversations') }}</h2>

            <div class="space-y-2 overflow-y-auto flex-grow min-h-0">
                @forelse($friendsList as $friend)
                    <div
                        wire:click="selectFriend({{ $friend->id }})"
                        class="flex cursor-pointer items-center gap-3 rounded-lg p-3 transition-colors hover:bg-neutral-100 dark:hover:bg-zinc-800
                        {{ $selectedFriend && $selectedFriend->id === $friend->id ? 'bg-neutral-100 dark:bg-zinc-800' : '' }}"
                    >
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white flex-shrink-0">
                            {{ $friend->initials() }}
                        </span>
                        <div class="flex-grow overflow-hidden">
                            <h3 class="font-medium dark:text-white truncate">{{ $friend->username }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                @php
                                    $lastMessage = Chat::where(function ($query) use ($friend) {
                                        $query->where('sender_id', auth()->id())
                                            ->where('recipient_id', $friend->id);
                                    })
                                    ->orWhere(function ($query) use ($friend) {
                                        $query->where('sender_id', $friend->id)
                                            ->where('recipient_id', auth()->id());
                                    })
                                    ->latest()
                                    ->first();
                                @endphp

                                @if($lastMessage)
                                    {{ \Illuminate\Support\Str::limit($lastMessage->message, 25) }}
                                @else
                                    {{ __('No messages yet') }}
                                @endif
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="h-3 w-3 rounded-full bg-green-500" title="{{ __('Online') }}"></div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-lg p-4 text-center dark:text-gray-400">
                        <p>{{ __('No friends to chat with.') }}</p>
                        <a href="{{ route('pages.friends') }}" class="mt-2 inline-block text-sm text-blue-500 hover:underline">
                            {{ __('Add some friends') }}
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="w-3/4 flex flex-col h-full bg-white dark:bg-zinc-900">
            @if($selectedFriend)
                <div class="flex-shrink-0 flex items-center border-b border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-zinc-900">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white flex-shrink-0">
                        {{ $selectedFriend->initials() }}
                    </span>
                    <div class="ml-3 overflow-hidden">
                        <h2 class="font-semibold dark:text-white truncate">{{ $selectedFriend->username }}</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $selectedFriend->email }}</p>
                    </div>
                </div>

                <div class="h-0 flex-grow overflow-y-auto p-4" id="messages-container"
                     x-data="{}"
                     x-init="$nextTick(() => { $el.scrollTop = $el.scrollHeight; })"
                     wire:poll.3s="refreshMessages">
                    <div class="space-y-4">
                        @forelse($messages as $msg)
                            <div class="flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[75%] rounded-xl {{ $msg->sender_id === auth()->id() ? 'bg-blue-500 text-white' : 'bg-neutral-100 dark:bg-zinc-800 dark:text-white' }} p-3 shadow-sm">
                                    <p class="break-words">{{ $msg->message }}</p>
                                    <p class="mt-1 text-xs text-right {{ $msg->sender_id === auth()->id() ? 'text-blue-200' : 'text-gray-500 dark:text-gray-400' }}">
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

                <!-- CRITICAL: This is a fixed-height footer -->
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
                        <p class="text-xl font-semibold dark:text-white">{{ __('Select a friend to start chatting') }}</p>
                        <p class="mt-2 text-gray-500 dark:text-gray-400">{{ __('Choose from your friends list or add new friends') }}</p>
                        <a href="{{ route('pages.friends') }}" class="mt-4 inline-block rounded-lg bg-blue-500 px-4 py-2 font-medium text-white hover:bg-blue-600">
                            {{ __('Manage Friends') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:initialized', () => {
                const messagesContainer = document.getElementById('messages-container');

                const scrollToBottom = () => {
                    console.log('Scrolling to bottom');
                    if (messagesContainer) {
                        messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    }
                };

                Livewire.on('messageSent', scrollToBottom);

                if (messagesContainer) {
                    scrollToBottom();
                }

                Livewire.on('friendSelected', () => {
                    setTimeout(scrollToBottom);
                });

                Livewire.on('messagesRefreshed', scrollToBottom);
            });

            document.addEventListener('livewire:load', function() {
                Livewire.hook('message.processed', (message, component) => {
                    const messagesContainer = document.getElementById('messages-container');
                    if (messagesContainer) {
                        const isNearBottom = (messagesContainer.scrollHeight - messagesContainer.scrollTop - messagesContainer.clientHeight) < 100;
                        if (isNearBottom) {
                            messagesContainer.scrollTop = messagesContainer.scrollHeight;
                        }
                    }
                });
            });
        </script>
    @endpush
</div>


