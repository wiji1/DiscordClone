<div>
    <form wire:submit.prevent="submitCreateRoom" class="space-y-4">
        <div>
            <label for="roomName" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                {{ __('Room Name') }}
            </label>
            <input
                type="text"
                id="roomName"
                wire:model="formRoomName"
                class="w-full rounded-lg border border-neutral-300 px-4 py-2 focus:border-blue-500 focus:outline-none dark:border-neutral-600 dark:bg-zinc-800 dark:text-white"
                placeholder="{{ __('Enter room name') }}"
                required
            >
            @error('formRoomName') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="roomDescription" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                {{ __('Description') }} <span class="text-xs text-zinc-500 dark:text-zinc-400">({{ __('Optional') }})</span>
            </label>
            <textarea
                id="roomDescription"
                wire:model="formRoomDescription"
                class="w-full rounded-lg border border-neutral-300 px-4 py-2 focus:border-blue-500 focus:outline-none dark:border-neutral-600 dark:bg-zinc-800 dark:text-white"
                placeholder="{{ __('Enter an optional description for the room') }}"
                rows="3"
            ></textarea>
            @error('formRoomDescription') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center pt-2">
            <input
                type="checkbox"
                id="isPublic"
                wire:model="formIsPublic"
                class="h-4 w-4 rounded border-neutral-300 text-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-zinc-700 dark:focus:ring-blue-600 dark:ring-offset-zinc-800"
            >
            <label for="isPublic" class="ml-2 block text-sm text-zinc-700 dark:text-zinc-300">
                {{ __('Make this room public') }}
                <span class="block text-xs text-zinc-500 dark:text-zinc-400">{{ __('Public rooms are visible to everyone.') }}</span>
            </label>
        </div>
        @error('formIsPublic') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
        <div class="pt-4 flex justify-end">
             <button
                 type="submit"
                 class="px-4 py-2 rounded-md bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-900"
             >
                 {{ __('Create Room') }}
             </button>
        </div>
    </form>
</div>
