<?php

namespace App\Livewire\Components;

use App\Models\Notification;
use App\Models\User;
use Livewire\Component;

class Notifications extends Component
{
    public function mount()
    {
        // No need for specific initialization
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);

        if ($notification && $notification->user_id === auth()->id()) {
            $notification->markAsRead();
        }
    }

    public function markAllAsRead()
    {
        auth()->user()->notifications()
            ->where('read', false)
            ->update(['read' => true]);
    }

    public function render()
    {
        return view('livewire.components.notifications');
    }
}
