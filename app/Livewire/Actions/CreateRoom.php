<?php

namespace App\Livewire\Actions;

use Livewire\Component;
use Livewire\Attributes\Rule;

class CreateRoom extends Component
{
    #[Rule('required|string|max:255')]
    public $formRoomName = '';

    #[Rule('nullable|string|max:1000')]
    public $formRoomDescription = '';

    #[Rule('boolean')]
    public $formIsPublic = false;

    public function submitCreateRoom(): void
    {
        logger($this->formRoomName);


        $validatedData = $this->validate();

        $this->dispatch('create-room-submitted',
            name: $validatedData['formRoomName'],
            description: $validatedData['formRoomDescription'],
            isPublic: $validatedData['formIsPublic']
        );
    }

    public function render()
    {
        return view('livewire.modals.create-room');
    }
}
