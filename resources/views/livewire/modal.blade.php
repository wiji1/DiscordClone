{{-- resources/views/livewire/modal.blade.php --}}
@php use App\Livewire\Modal; @endphp
<div>
    @if($isOpen)
        <div
            id="{{ $modalId }}"
            x-data="{ open: $wire.entangle('isOpen') }"
            x-show="open"
            x-on:keydown.escape.window="open = false; $wire.call('closeModal')" {{-- Also call Livewire close to reset state --}}
            x-cloak {{-- Add x-cloak to prevent FOUC --}}
            class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true"
        >
            <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div
                    class="fixed inset-0 bg-zinc-900/20 backdrop-blur-sm transition-opacity" {{-- Added backdrop-blur-sm and reduced opacity --}}
                aria-hidden="true"
                    x-show="open"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    x-on:click="open = false; $wire.call('closeModal')" {{-- Also call Livewire close to reset state --}}
                ></div>

                <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block transform overflow-hidden rounded-lg bg-white dark:bg-zinc-900 text-left align-bottom shadow-xl transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                    :class="{
                        'sm:max-w-sm': '{{ $modalSize }}' === 'sm',
                        'sm:max-w-lg': '{{ $modalSize }}' === 'md',
                        'sm:max-w-xl': '{{ $modalSize }}' === 'lg',
                        'sm:max-w-3xl': '{{ $modalSize }}' === 'xl',
                    }"
                    style="will-change: transform, opacity;" {{-- Add will-change hint --}}
                    x-show="open"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    @click.away="open = false; $wire.call('closeModal')" {{-- Added Livewire call here too for consistency --}}
                >
                    <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4"> {{-- Adjusted padding slightly for common patterns --}}
                        <div class="flex items-start justify-between pb-4"> {{-- Added padding-bottom --}}
                            <h3 class="text-lg font-medium leading-6 text-zinc-900 dark:text-white" id="modal-title">
                                {{ $title }}
                            </h3>
                            <button
                                type="button"
                                class="-mt-1 -mr-1 rounded-md p-1 text-zinc-400 hover:text-zinc-500 dark:hover:text-zinc-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-900"
                                {{-- Adjusted styling for better click target and consistency --}}
                                wire:click="closeModal" {{-- Use wire:click directly to call the method --}}
                            >
                                <span class="sr-only">Close</span>
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"> {{-- Adjusted stroke-width --}}
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="mt-2"> {{-- Reduced default top margin slightly --}}
                            @if(is_string($content) && !empty($content))
                                @if(class_exists($content) && is_subclass_of($content, \Livewire\Component::class)) {{-- More robust check --}}
                                @livewire($content, $componentParams, key('modal-content-'.$modalId))
                                @else
                                    {{-- Allow basic HTML in content if needed, or escape it --}}
                                    <div class="text-sm text-zinc-600 dark:text-zinc-400">
                                        {!! $content !!} {{-- Use {!! !!} if content might contain HTML, use {{ }} to escape --}}
                                    </div>
                                @endif
                            @elseif(is_object($content) && $content instanceof \Livewire\Component) {{-- Check if it's a component instance --}}
                            {{-- This case is less common via dispatch, usually you pass the class name --}}
                            <livewire:is :component="$content" :key="'modal-content-'.$modalId" :params="$componentParams" />
                            @elseif(is_string($content) && class_exists($content) && is_subclass_of($content, \Livewire\Component::class)) {{-- Check if it's a class name string again --}}
                            @livewire($content, $componentParams, key('modal-content-'.$modalId))
                            @endif
                        </div>
                    </div>

                    @if($showFooter)
                        {{-- Added border top for separation --}}
                        <div class="bg-zinc-50 dark:bg-zinc-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-zinc-200 dark:border-zinc-700 rounded-b-lg">
                            <button
                                type="button"
                                class="inline-flex w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800 sm:ml-3 sm:w-auto sm:text-sm"
                                wire:click="confirm"
                            >
                                {{ $confirmText }}
                            </button>
                            <button
                                type="button"
                                class="mt-3 inline-flex w-full justify-center rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-4 py-2 text-base font-medium text-zinc-700 dark:text-zinc-300 shadow-sm hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800 sm:mt-0 sm:w-auto sm:text-sm"
                                wire:click="closeModal" {{-- Use wire:click directly --}}
                            >
                                {{ $cancelText }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
