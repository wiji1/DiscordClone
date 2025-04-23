<?php

namespace App\Livewire\Actions;

use Livewire\Component;
use Livewire\Attributes\Rule;

class JoinRoom extends Component
{
    #[Rule('required|string|max:255')]
    public $formInviteCode = '';

    public function submitJoinRoom(): void
    {
        logger($this->formInviteCode);


        $validatedData = $this->validate();

        $this->dispatch('join-room-submitted',
            code: $validatedData['formInviteCode'],

        );
    }

    public function render()
    {
        return view('livewire.modals.join-room');
    }
}
