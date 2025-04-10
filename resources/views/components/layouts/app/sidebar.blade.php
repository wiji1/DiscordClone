<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
@livewire('modal')

<body class="min-h-screen bg-white dark:bg-zinc-800">
<flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

    <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
        <x-app-logo />
    </a>

    <flux:navlist variant="outline" id="openModalButton">
        <div>
            @php
                $unreadCount = auth()->user()->notifications()->where('read', false)->count();
            @endphp
            <flux:navlist.item icon="bell"
                               @click="$dispatch('open-custom-modal', {
                data: {
                    modalId: 'notifications-modal',
                    title: 'Notifications',
                    content: 'App\\\\Livewire\\\\Components\\\\Notifications',
                    size: 'xl',
                    showFooter: false,
                }
            })">
                {{ __('Notifications') }}
                @if($unreadCount > 0)
                    <span class="ml-2 inline-flex items-center justify-center px-1.5 py-0.5 text-[11px] font-medium rounded-full bg-blue-500 text-white dark:bg-blue-600 dark:text-blue-100 self-center">
                {{ $unreadCount }}
            </span>
                @endif
            </flux:navlist.item>
        </div>
    </flux:navlist>

    <flux:navlist variant="outline">
        <flux:navlist.group :heading="__('Friends')" class="grid gap-1">
            <flux:navlist.item icon="user" :href="route('pages.friends')" :current="request()->routeIs('pages.friends')" wire:navigate>{{ __('Friends') }}</flux:navlist.item>
            <br>
            @php
                $friends = auth()->user()->getFriends();
            @endphp

            @foreach ($friends as $friend)
                <flux:navlist.item class="block px-3 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-lg">
                    <div class="flex items-center gap-3 w-full">
                                <span class="flex-shrink-0 flex h-8 w-8 items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ $friend->initials() }}
                                </span>
                        <div class="flex-grow min-w-0 overflow-hidden">
                            <div class="font-semibold truncate">{{ $friend->username }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $friend->email }}</div>
                        </div>
                    </div>
                </flux:navlist.item>
            @endforeach
        </flux:navlist.group>
    </flux:navlist>

    <flux:navlist variant="outline">
        <flux:navlist.group :heading="__('Servers')" class="grid">
            <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
        </flux:navlist.group>
    </flux:navlist>

    <flux:spacer />

    <flux:navlist variant="outline" id="openModalButton">
        <div>
            <flux:navlist.item icon="user-search"
             @click="$dispatch('open-custom-modal', {
                        data: {
                            modalId: 'add-friend-modal',
                            title: 'Add Friend',
                            content: 'App\\\\Livewire\\\\Actions\\\\AddFriend',
                            size: 'md',
                            showFooter: false,
                        }
                    })">
                {{ __('Add Friend') }}
            </flux:navlist.item>
        </div>
        <flux:navlist.item icon="server" @click="$dispatch('open-custom-modal', {
                        data: {
                            modalId: 'join-server-modal',
                            title: 'Join Server',
                            content: 'App\\\\Livewire\\\\Actions\\\\JoinServer',
                            size: 'md',
                            showFooter: false,
                        }
                    })">
            {{ __('Join Server') }}
        </flux:navlist.item>
    </flux:navlist>

    <!-- Desktop User Menu -->
    <flux:dropdown position="bottom" align="start">
        <flux:profile
            :name="auth()->user()->username"
            :initials="auth()->user()->initials()"
            icon-trailing="chevrons-up-down"
        />

        <flux:menu class="w-[220px]">
            <flux:menu.radio.group>
                <div class="p-0 text-sm font-normal">
                    <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                        <div class="grid flex-1 text-left text-sm leading-tight">
                            <span class="truncate font-semibold">{{ auth()->user()->username }}</span>
                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                </div>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <flux:menu.radio.group>
                <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                    {{ __('Log Out') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:sidebar>


<!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->username }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
        @livewireScripts
    </body>
</html>
