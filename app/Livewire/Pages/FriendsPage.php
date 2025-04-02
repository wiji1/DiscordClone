<?php

namespace App\Livewire\Pages;

use App\Livewire\Actions\AddFriend;
use App\Models\FriendRequest;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class FriendsPage extends Component
{
    use WithPagination;

    public function acceptFriendRequest($username): void
    {
        $addFriend = new AddFriend();
        $addFriend->username = $username;

        $addFriend->addFriend();
    }

    public function rejectFriendRequest($username): void
    {
        $request = FriendRequest::where('recipient_id', auth()->id())
            ->where('sender_id', User::where('username', $username)->first()->id)
            ->first();

        $request->delete();
    }

    public function mount()
    {
        // Initialize component
    }

    public function render()
    {
        return view('livewire.pages.friends');
    }
}
