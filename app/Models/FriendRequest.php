<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FriendRequest extends Model
{
    protected $table = 'friend_requests';

    protected $fillable = [
        'sender_id',
        'recipient_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function friend()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}
