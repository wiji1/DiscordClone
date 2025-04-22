<?php

namespace App\Livewire\Pages;

use App\Models\ChatRoom;
use App\Models\ChatRoomMessage;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;

class ChatRoomsPage extends Component
{
    use WithPagination;

    public $selectedRoom = null;
    public $message = '';
    public $messages = [];
    public $roomsList = [];
    public $showCreateRoomModal = false;
    public $showJoinRoomModal = false;
    public $showMembersModal = false;
    public $showInviteModal = false;

    public $formRoomName = '';
    public $formRoomDescription = '';
    public $formInviteCode = '';
    public $formIsPublic = false;

    public $roomMembers = [];

    protected $listeners = [
        'refreshChat' => '$refresh',
        'messageReceived' => 'refreshMessages',
        'roomCreated' => 'handleRoomCreated',
        'roomJoined' => 'handleRoomJoined',
        'refreshRooms' => 'loadRooms'
    ];

    public function handleRoomCreated($roomId)
    {
        $this->loadRooms();
        $this->selectRoom($roomId);
        $this->showCreateRoomModal = false;
    }

    public function handleRoomJoined($roomId)
    {
        $this->loadRooms();
        $this->selectRoom($roomId);
        $this->showJoinRoomModal = false;
    }

    public function mount($roomId = null)
    {
        $this->loadRooms();

        if ($roomId) {
            $this->selectRoom($roomId);
        } elseif (count($this->roomsList) > 0) {
            $this->selectRoom($this->roomsList->first()->id);
        }
    }

    public function loadRooms()
    {
        $this->roomsList = auth()->user()->chatRooms()->get();
    }

    public function selectRoom($roomId)
    {
        $this->selectedRoom = ChatRoom::findOrFail($roomId);
        $this->loadMessages();
        $this->resetPage();
        $this->dispatch('roomSelected');
    }

    public function loadMessages()
    {
        if (!$this->selectedRoom) {
            return;
        }

        $oldCount = count($this->messages);

        $this->messages = ChatRoomMessage::with('user')
            ->where('chat_room_id', $this->selectedRoom->id)
            ->orderBy('created_at', 'asc')
            ->get();

        $newCount = count($this->messages);

        $this->dispatch('messagesRefreshed', hasNewMessages: $newCount > $oldCount);
    }

    public function sendMessage()
    {
        if (!$this->selectedRoom) {
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
            ChatRoomMessage::create([
                'chat_room_id' => $this->selectedRoom->id,
                'user_id' => auth()->id(),
                'message' => $messageToSend,
            ]);
        }

        $this->loadMessages();
        $this->dispatch('messageSent', shouldScroll: true);
    }

    public function refreshMessages()
    {
        $this->loadMessages();
    }

    public function openCreateRoomModal()
    {
        $this->reset(['formRoomName', 'formRoomDescription', 'formIsPublic']);
        $this->showCreateRoomModal = true;
    }

    public function createRoom()
    {
        $validator = Validator::make(
            ['formRoomName' => $this->formRoomName],
            ['formRoomName' => 'required|string|max:255'],
            ['formRoomDescription' => $this->formRoomDescription],
            ['formRoomDescription' => 'nullable|string|max:1000'],
        );

        if ($validator->fails()) {
            $this->dispatch('error', message: 'Message validation failed');
            return null;
        }


        $room = ChatRoom::create([
            'name' => $this->formRoomName,
            'description' => $this->formRoomDescription,
            'owner_id' => auth()->id(),
            'is_public' => $this->formIsPublic
        ]);

        $room->users()->attach(auth()->id(), ['role' => 'owner']);

        $this->handleRoomCreated($room->id);

        return redirect()->route('pages.chat-rooms', ['roomId' => $room->id]);
    }

    public function openJoinRoomModal()
    {
        $this->reset('formInviteCode');
        $this->showJoinRoomModal = true;
    }

    public function joinRoom()
    {

        $validator = Validator::make(
            ['formInviteCode' => $this->formInviteCode],
            ['formInviteCode' => 'required|string|exists:chat_rooms,invite_code']
        );

        if ($validator->fails()) {
            $this->dispatch('error', message: 'Message validation failed');
            return null;
        }

        $room = ChatRoom::where('invite_code', $this->formInviteCode)->first();

        if (auth()->user()->isChatRoomMember($room)) {
            $this->dispatch('error', message: 'You are already a member of this room');
            return null;
        }

        $room->users()->attach(auth()->id(), ['role' => 'member']);

        $this->handleRoomJoined($room->id);

        return redirect()->route('pages.chat-rooms', ['roomId' => $room->id]);
    }

    public function leaveRoom()
    {
        if (!$this->selectedRoom) {
            return null;
        }

        if ($this->selectedRoom->owner_id === auth()->id()) {
            $this->dispatch('error', message: 'You are the owner of this room. Transfer ownership before leaving.');
            return null;
        }

        $this->selectedRoom->users()->detach(auth()->id());
        $this->loadRooms();

        if (count($this->roomsList) > 0) {
            $this->selectRoom($this->roomsList->first()->id);
        } else {
            $this->selectedRoom = null;
            $this->messages = [];
        }

        return redirect()->route('pages.chat-rooms');
    }

    public function showMembers()
    {
        if (!$this->selectedRoom) {
            return;
        }

        $this->roomMembers = $this->selectedRoom->users()->withPivot('role')->get();
        $this->showMembersModal = true;
    }

    public function showInviteInfo()
    {
        if (!$this->selectedRoom) {
            return;
        }

        $this->showInviteModal = true;
    }

    public function regenerateInviteCode()
    {
        if (!$this->selectedRoom || $this->selectedRoom->owner_id !== auth()->id()) {
            return;
        }

        $this->selectedRoom->generateNewInviteCode();
    }

    public function render()
    {
        return view('livewire.pages.chat-rooms');
    }
}
