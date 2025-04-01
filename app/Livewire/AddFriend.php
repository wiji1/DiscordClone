<?php

namespace App\Livewire;

use Livewire\Component;

class AddFriend extends Component
{
    public $username = '';
    public $message = '';

    public function addFriend()
    {
        // Validate input
        $this->validate([
            'username' => 'required|min:3|max:50',
        ]);

        // Add friend logic here
        // ...

        // Show success message
        $this->message = "Friend request sent to {$this->username}";

        // Reset form
        $this->reset('username');

        // Close modal after successful submission
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.add-friend');
    }
}
