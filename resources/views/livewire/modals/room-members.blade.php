<div class="max-h-60 overflow-y-auto">
    <ul class="divide-y divide-zinc-200 dark:divide-zinc-700">
        @forelse($roomMembers as $member)
            <li class="py-3 flex items-center justify-between">
                <div class="flex items-center">
                                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white flex-shrink-0">
                                        {{ $member->initials() }}
                                    </span>
                    <div class="ml-3">
                        <p class="font-medium dark:text-white">{{ $member->username }}</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                            {{ $member->pivot->role }}
                        </p>
                    </div>
                </div>

                @if($selectedRoom->owner_id === auth()->id() && $member->id !== auth()->id())
                    <button
                        type="button"
                        class="text-red-500 hover:text-red-700 text-sm"
                    >
                        {{ __('Remove') }}
                    </button>
                @endif
            </li>
        @empty
            <li class="py-3 text-center text-zinc-500 dark:text-zinc-400">
                {{ __('No members found') }}
            </li>
        @endforelse
    </ul>
</div>
