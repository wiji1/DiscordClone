<x-layouts.app.sidebar :title="$title ?? null">
    @stack('scripts')
    @livewire('modal')

    @livewireStyles
    @livewireScripts

    <flux:main>
        {{ $slot }}
    </flux:main>

</x-layouts.app.sidebar>

