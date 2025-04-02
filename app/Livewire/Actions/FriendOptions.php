<?php

namespace App\Livewire\Actions;

use App\Models\Friendship;
use App\Models\User;
use Livewire\Component;

class FriendOptions extends Component
{
    public $friendId;

    public function mount($friendId)
    {
        $this->friendId = $friendId;
    }

    public function removeFriend()
    {
        Friendship::where('user_id', auth()->id())
            ->where('friend_id', $this->friendId)
            ->delete();

        Friendship::where('user_id', $this->friendId)
            ->where('friend_id', auth()->id())
            ->delete();

        $this->dispatch('refreshView');
        $this->dispatch('close-modal');
    }

    public function blockUser()
    {
        $this->removeFriend();

        //TODO: Add block user logic here

        $this->dispatch('refreshView');
        $this->dispatch('close-modal');
    }

    public function render()
    {
        $friend = User::find($this->friendId);

        return view('livewire.modals.friend-options', [
            'friend' => $friend
        ]);
    }
}
