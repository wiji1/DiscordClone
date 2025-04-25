<?php

namespace App\Livewire\Actions;

use Livewire\Component;

class JoinServer extends Component
{
    public $serverId = '';
    public $message = '';

    public function joinServer()
    {
        $this->validate([
            'serverId' => 'required|min:3|max:50',
        ]);

        $this->message = "Successfully joined {$this->serverId}";

        $this->reset('serverId');

        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.modals.join-server');
    }
}
