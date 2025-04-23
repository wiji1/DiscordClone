<?php

namespace App\Livewire\Actions;

use App\Models\ChatRoom;
use Livewire\Component;

class RoomMembers extends Component
{
    public $roomId;
    public $selectedRoom;
    public $roomMembers = [];

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

        $this->roomMembers = $this->selectedRoom->users()->withPivot('role')->get();
    }

    public function render()
    {
        return view('livewire.modals.room-members');
    }
}
