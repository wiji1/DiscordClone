<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->username) ->substr(0, 1);
    }

    public function getFriends()
    {
        return Friendship::where('user_id', $this->id)
            ->orWhere('friend_id', $this->id)
            ->get()
            ->map(function ($friendship) {
                return $friendship->user_id === $this->id
                    ? $friendship->friend
                    : $friendship->user;
            });
    }

    public function getFriendRequests()
    {
        return FriendRequest::where('recipient_id', $this->id)
            ->get();
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
