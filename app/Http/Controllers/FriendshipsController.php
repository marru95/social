<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Friendship;
use Illuminate\Http\Request;

class FriendshipsController extends Controller
{
    public function store(User $recipient)
    {

        if(auth()->id() === $recipient->id)
        {
            abort(400);
        }

        $friendship = Friendship::firstOrCreate([
            'sender_id' => auth()->id(),
            'recipient_id' => $recipient->id
        ]);

        return response()->json([
            'friendship_status' => $friendship->fresh()->status
        ]);
    }

    public function index()
    {

        $friendshipRequests = Friendship::with('sender')->where([
            'recipient_id' => auth()->id(),
        ])->get();

        return view('friendships.index', compact('$friendshipRequests'));
    }


    public function destroy(User $user)
    {

        $friendship = Friendship::where([
            'sender_id' => auth()->id(),
            'recipient_id' => $user->id
        ])->orWhere([
            'sender_id' => $user->id,
            'recipient_id' => auth()->id(),
        ])->first();

        if ($friendship->status === 'denied')
        {
            return response()->json([
                'friendship_status' => 'denied'
            ]);
        }


        return response()->json([
            'friendship_status' => $friendship->delete() ? 'deleted' : ''
        ]);
    }


}
