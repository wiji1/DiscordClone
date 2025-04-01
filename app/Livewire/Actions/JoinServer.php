<?php

namespace App\Livewire\Actions;

use Livewire\Component;

class JoinServer extends Component
{
    public $serverId = '';
    public $message = '';

    public function joinServer()
    {
        // Validate input
        $this->validate([
            'serverId' => 'required|min:3|max:50',
        ]);

        // Add friend logic here
        // ...

        // Show success message
        $this->message = "Successfully joined {$this->serverId}";

        // Reset form
        $this->reset('serverId');

        // Close modal after successful submission
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.modals.join-server');
    }
}
