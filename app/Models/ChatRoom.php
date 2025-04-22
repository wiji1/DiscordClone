<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'owner_id', 'invite_code', 'is_public'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($room) {
            if (empty($room->invite_code)) {
                $room->invite_code = Str::random(10);
            }
        });
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function messages()
    {
        return $this->hasMany(ChatRoomMessage::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'chat_room_users')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function members()
    {
        return $this->users();
    }

    public function admins()
    {
        return $this->users()->wherePivot('role', 'admin');
    }

    public function generateNewInviteCode()
    {
        $this->invite_code = Str::random(10);
        $this->save();

        return $this->invite_code;
    }

    public function name()
    {
        return $this->name;
    }
}
