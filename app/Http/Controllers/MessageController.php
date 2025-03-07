<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {

        $user = auth()->user();
        $followers = $user->followers;
        $following = $user->following;
        $connections = $followers -> concat($following);
        return view('messages', compact('connections'));
    }
    public function chat(User $user)
    {
        // dd($user ->id);
        $userAuth = auth()->user();
        $followers = $userAuth->followers;
        $following = $userAuth->following;
        $connections = $followers -> concat($following);
        $messages = Message::where('sender_id',$userAuth->id)
        -> where('reciever_id',$user->id)
        -> orWhere('sender_id',$user->id)
        ->where('reciever_id',$userAuth->id) -> get();
        $talkedTo = $connections->where('id', $user->id)->first();
        
        return view('messages', compact('talkedTo', 'connections','messages'));
    }
    public function send(User $user, Request $request)
    {
        
        $validate = $request->validate([
            'message' => 'required'
        ]);
            Message::create([
            'sender_id' => auth()->id(),
            'reciever_id' => $user->id,
            'message' => $validate['message']
        ]);
        return redirect()-> back();
    }

}
