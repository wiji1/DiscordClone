<?php

namespace App\Livewire\Actions;

use App\Models\ChatRoom;
use Livewire\Component;

class RoomInvite extends Component
{
    public $roomId;
    public $selectedRoom;

    public function mount($roomId = null)
    {
        $this->roomId = $roomId;

        $this->selectedRoom = ChatRoom::findOrFail($roomId);

        if (!$this->selectedRoom) {
            $this->dispatch('close-modal');
            $this->dispatch('notify',
                message: 'Room not found',
                type: 'error'
            );
        }
    }

    public function render()
    {
        return view('livewire.modals.room-invite');
    }

    public function regenerateInviteCode()
    {
        if ($this->selectedRoom && $this->selectedRoom->owner_id === auth()->id()) {
            $this->selectedRoom->generateNewInviteCode();
            $this->selectedRoom->save();

            $this->dispatch('notify',
                message: 'New invite code generated!',
                type: 'success'
            );
        } else {
            $this->dispatch('notify',
                message: 'Failed to generate code.',
                type: 'error'
            );
        }
    }
}
