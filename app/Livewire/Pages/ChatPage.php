<?php

namespace App\Livewire\Pages;

use App\Models\Chat;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;

class ChatPage extends Component
{
    use WithPagination;

    public $selectedFriend = null;
    public $message = '';
    public $messages = [];
    public $friendsList = [];
    public $messageCount = 0;

    protected $listeners = ['refreshChat' => '$refresh', 'messageReceived' => 'refreshMessages'];

    public function mount($friendId = null): void
    {
        $this->friendsList = auth()->user()->getFriends();

        if ($friendId) {
            $this->selectedFriend = User::findOrFail($friendId);
            $this->loadMessages();
        } elseif (count($this->friendsList) > 0) {
            $this->selectedFriend = $this->friendsList->first();
            $this->loadMessages();
        }
    }

    public function selectFriend($friendId): void
    {
        $this->selectedFriend = User::findOrFail($friendId);
        $this->loadMessages();
        $this->resetPage();
        $this->dispatch('friendSelected');
    }

    public function loadMessages(): void
    {
        if (!$this->selectedFriend) {
            return;
        }

        $oldCount = count($this->messages);

        $this->messages = Chat::where(function ($query) {
            $query->where('sender_id', auth()->id())
                ->where('recipient_id', $this->selectedFriend->id);
        })
            ->orWhere(function ($query) {
                $query->where('sender_id', $this->selectedFriend->id)
                    ->where('recipient_id', auth()->id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $newCount = count($this->messages);

        // Dispatch event with flag indicating if new messages were added
        $this->dispatch('messagesRefreshed', hasNewMessages: $newCount > $oldCount);

        Chat::where('sender_id', $this->selectedFriend->id)
            ->where('recipient_id', auth()->id())
            ->where('read', false)
            ->update(['read' => true]);
    }

    public function sendMessage(): void
    {
        if (!$this->selectedFriend) {
            return;
        }

        $validator = Validator::make(
            ['message' => $this->message],
            ['message' => 'required|string|max:1000']
        );

        if ($validator->fails()) {
            $this->dispatch('error', message: 'Message validation failed');
            return;
        }

        $messageToSend = trim($this->message);

        $this->reset('message');

        if (!empty($messageToSend)) {
            Chat::create([
                'sender_id' => auth()->id(),
                'recipient_id' => $this->selectedFriend->id,
                'message' => $messageToSend,
            ]);
        }

        $this->loadMessages();
        $this->dispatch('messageSent', shouldScroll: true);
    }

    public function refreshMessages(): void
    {
        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.pages.chat');
    }
}
