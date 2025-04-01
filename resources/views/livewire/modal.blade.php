<div>
    @if($isOpen)
        <div
            id="{{ $modalId }}"
            x-data="{ open: @entangle('isOpen') }"
            x-show="open"
            x-on:keydown.escape.window="open = false"
            class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true"
        >
            <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div
                    class="fixed inset-0 bg-zinc-500 bg-opacity-75 transition-opacity"
                    aria-hidden="true"
                    x-show="open"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    x-on:click="open = false"
                ></div>

                <!-- This centers the modal contents -->
                <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>

                <!-- Modal panel -->
                <div
                    class="inline-block transform overflow-hidden rounded-lg bg-white dark:bg-zinc-900 text-left align-bottom shadow-xl transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                    :class="{
                    'sm:max-w-sm': '{{ $modalSize }}' === 'sm',
                    'sm:max-w-lg': '{{ $modalSize }}' === 'md',
                    'sm:max-w-xl': '{{ $modalSize }}' === 'lg',
                    'sm:max-w-3xl': '{{ $modalSize }}' === 'xl',
                }"
                    x-show="open"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    @click.away="open = false"
                >
                    <div class="px-4 pt-5 pb-4 sm:p-6">
                        <div class="flex items-start justify-between">
                            <h3 class="text-lg font-medium leading-6 text-zinc-900 dark:text-white" id="modal-title">
                                {{ $title }}
                            </h3>
                            <button type="button" class="rounded-md bg-white dark:bg-zinc-900 text-zinc-400 hover:text-zinc-500 dark:hover:text-zinc-300 focus:outline-none" @click="open = false">
                                <span class="sr-only">Close</span>
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="mt-3 sm:mt-4">
                            @if(is_string($content))
                                <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $content }}
                                </div>
                            @else
                                <livewire:is :component="$content" :key="'modal-content-'.$modalId" />
                            @endif
                        </div>

                        <div class="mt-5 sm:mt-6 flex justify-end space-x-2">
                            <button
                                type="button"
                                class="inline-flex justify-center rounded-md border border-transparent bg-zinc-200 dark:bg-zinc-700 px-4 py-2 text-sm font-medium text-zinc-900 dark:text-white hover:bg-zinc-300 dark:hover:bg-zinc-600 focus:outline-none"
                                @click="open = false"
                            >
                                Close
                            </button>

                            <button
                                type="button"
                                class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none"
                                wire:click="$dispatch('modal-confirmed', {modalId: '{{ $modalId }}'})"
                            >
                                Confirm
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
