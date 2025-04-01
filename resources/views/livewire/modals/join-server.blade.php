<div>
    <!-- Success Message -->
    @if($message)
        <div class="mb-4 rounded-md bg-green-50 p-4 dark:bg-green-900/20">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800 dark:text-green-400">{{ $message }}</p>
                </div>
            </div>
        </div>
    @endif

    <form wire:submit.prevent="joinServer">
        <div class="mb-4">
            <label for="serverId" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Server ID</label>
            <div class="mt-1">
                <input
                    type="text"
                    name="serverId"
                    id="serverId"
                    wire:model="serverId"
                    class="block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white sm:text-sm"
                    placeholder="Enter server ID or invite code"
                >
            </div>
            @error('serverId')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <button
            type="submit"
            class="w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none"
        >
            Join Server
        </button>
    </form>
</div>
