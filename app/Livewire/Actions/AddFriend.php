<?php

namespace App\Livewire\Actions;

use App\Http\Controllers\FriendController;
use App\Models\FriendRequest;
use App\Models\Friendship;
use App\Models\Notification;
use App\Models\User;
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

        $user = User::where('username', $this->username)->first();

        if (!$user) {
            $this->addError('username', 'User not found');
            return;
        }

        $sender = auth()->user();

        if ($sender->id === $user->id) {
            $this->addError('username', 'You cannot send a friend request to yourself');
            return;
        }

        $existingRequest = FriendController::getFriendRequest($sender->id, $user->id);

        if ($existingRequest) {
            $this->addError('username', 'Friend request already sent');
            return;
        }

        $existingFriendship = FriendController::getFriendship($sender->id, $user->id);

        if ($existingFriendship) {
            $this->addError('username', 'You are already friends with this user');
            return;
        }

        FriendRequest::create([
            'sender_id' => $sender->id,
            'recipient_id' => $user->id,
        ]);

        Notification::create([
            'user_id' => $user->id,
            'message' => 'You have a new friend request from ' . $sender->username,
            'link' => route('pages.friends'),
        ]);

        FriendController::handleFriendship($sender->id, $user->id);

        // Show success message
        $this->message = "Friend request sent to {$this->username}";

        // Reset form
        $this->reset('username');

        // Close modal after successful submission
        $this->dispatch('close-modal');
        $this->dispatch('refreshView');
    }

    public function render()
    {
        return view('livewire.modals.add-friend');
    }
}
