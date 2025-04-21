<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\Friendship;
use Illuminate\Http\Request;

class FriendController extends Controller
{


    public static function handleFriendship($user1, $user2)
    {
        $user1_request = self::getFriendRequest($user1, $user2);
        $user2_request = self::getFriendRequest($user2, $user1);

        if ($user1_request and $user2_request) {
            $user1_request->delete();
            $user2_request->delete();

            Friendship::create([
                'user_id' => $user1,
                'friend_id' => $user2,
            ]);
        }
    }

    public static function getFriendship($user1, $user2)
    {
        $friendship = Friendship::where('user_id', $user1)
            ->where('friend_id', $user2)
            ->first();

        if ($friendship) {
            return $friendship;
        }

        $friendship = Friendship::where('user_id', $user2)
            ->where('friend_id', $user1)
            ->first();

        if ($friendship) {
            return $friendship;
        }

        return null;
    }

    public static function getFriendRequest($sender, $recipient)
    {
        return FriendRequest::where('sender_id', $sender)
            ->where('recipient_id', $recipient)
            ->first();
    }
}
