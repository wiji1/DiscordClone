    <div>
        <form wire:submit.prevent="submitJoinRoom" class="space-y-4">
            <!-- Container with fixed height for error message to prevent layout shift -->
            <div class="min-h-[28px]">
                <div
                    x-data="{ errorMessage: '', showError: false }"
                    x-on:error.window="errorMessage = $event.detail.message; showError = true; setTimeout(() => showError = false, 5000)"
                    x-show="showError"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 px-2 py-1 mb-1"
                    role="alert"
                >
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700 dark:text-red-200" x-text="errorMessage"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <label for="inviteCode" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                    {{ __('Invite Code') }}
                </label>
                <input
                    type="text"
                    id="inviteCode"
                    wire:model="formInviteCode"
                    class="w-full rounded-lg border border-neutral-300 px-4 py-2 focus:border-blue-500 focus:outline-none dark:border-neutral-600 dark:bg-zinc-800 dark:text-white"
                    placeholder="{{ __('Enter room invite code') }}"
                    required
                >
                @error('formInviteCode') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4 flex justify-end">
                <button
                    type="submit"
                    class="px-4 py-2 rounded-md bg-green-500 text-white hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-900"
                >
                    {{ __('Join Room') }}
                </button>
            </div>
        </form>
    </div>
