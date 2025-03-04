<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggleLike(Post $post)
    {
        $like = $post->likes()->where('user_id', auth()->id())->first();
        
        if ($like) {
            $like->delete();
            $isLiked = false;
        } else {
            $post->likes()->create([
                'user_id' => auth()->id(),
                'post:id' => $post->id
            ]);
            $isLiked = true;
            User::find($post -> user_id) -> notify(new UserNotification('like',Auth::user() -> name));
        }
        
        return redirect()->back();
    }

}
