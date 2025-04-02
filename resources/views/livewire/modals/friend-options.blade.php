<div class="p-4">
    <div class="space-y-4">
        <button
            wire:click="removeFriend"
            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-left text-sm font-medium text-neutral-700 hover:bg-neutral-50 dark:border-neutral-600 dark:bg-zinc-800 dark:text-neutral-200 dark:hover:bg-zinc-700"
        >
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-neutral-500 dark:text-neutral-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm3 11.25a.75.75 0 0 1-.75.75H2.75a.75.75 0 0 1 0-1.5h10.5a.75.75 0 0 1 .75.75zM5.5 10.25a.75.75 0 0 1 .75-.75h3.5a.75.75 0 0 1 0 1.5h-3.5a.75.75 0 0 1-.75-.75z" />
                </svg>
                {{ __('Remove Friend') }}
            </div>
        </button>

        <button
            wire:click="blockUser"
            class="w-full rounded-lg border border-red-300 bg-white px-4 py-2 text-left text-sm font-medium text-red-600 hover:bg-red-50 dark:border-red-800 dark:bg-zinc-800 dark:text-red-400 dark:hover:bg-red-900/20"
        >
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                {{ __('Block User') }}
            </div>
        </button>
    </div>
</div>
