<?php

namespace App\Livewire\Actions;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AddFriend extends Component
{
    public $username = '';
    public $message = '';

    public function addFriend()
    {
        $this->validate([
            'username' => 'required|min:3|max:50',
        ]);

        $users = DB::select('select * from users where username = ?', [$this->username]);
        if (count($users) === 0) {
            $this->addError('username', 'User not found');
            return;
        }

        $user = $users[0];
        //TODO: Send friend request to $user->id

        // Show success message
        $this->message = "Friend request sent to {$this->username}";

        // Reset form
        $this->reset('username');

        // Close modal after successful submission
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.modals.add-friend');
    }
}
