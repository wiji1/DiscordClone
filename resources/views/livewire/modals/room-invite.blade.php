
<div>
    <div class="space-y-4">
        <div>
            <p class="mb-2 text-sm text-zinc-700 dark:text-zinc-300">{{ __('Share this invite code with friends to join this room:') }}</p>
            <div class="flex">
                <input
                    type="text"
                    value="{{ $selectedRoom->invite_code }}"
                    class="flex-1 rounded-l-lg border border-neutral-300 px-4 py-2 bg-zinc-50 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white"
                    readonly
                >
                <button
                    type="button"
                    class="rounded-r-lg bg-blue-500 px-4 text-white hover:bg-blue-600"
                    onclick="copyToClipboard('{{ $selectedRoom->invite_code }}')"
                >
                    {{ __('Copy') }}
                </button>
            </div>
        </div>

        <div id="copy-toast" class="hidden fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg transition-opacity duration-500 opacity-0 z-50">
            {{ __('Copied to clipboard!') }}
        </div>

        @if($selectedRoom->owner_id === auth()->id())
            <div>
                <p class="mb-2 text-sm text-zinc-700 dark:text-zinc-300">{{ __('You can also generate a new invite code:') }}</p>
                <button
                    type="button"
                    class="w-full px-4 py-2 rounded-md bg-yellow-500 text-white hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800"
                    wire:click="regenerateInviteCode"
                >
                    {{ __('Generate New Code') }}
                </button>
                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">{{ __('Note: This will invalidate the previous invite code.') }}</p>
            </div>
        @endif
    </div>
</div>

