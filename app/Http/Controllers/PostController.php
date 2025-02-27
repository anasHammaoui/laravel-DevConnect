<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;

class PostController extends Controller
{
    public function index(){
        $allPosts = Post::get();
        // dd($allPosts);
        return view("dashboard", ["allPosts"=>$allPosts]);
    }
    public function store(Request $request){
        $request->validate([
            "content" => "required|min:5",
        ]);
        $contentType = null;
        $content = null;
        if ($request -> code !== null){
            $contentType = "code";
            $content = $request -> code;
        } elseif($request -> link !== null){
            $contentType = "link";
            $content = $request -> link;
        } elseif ($request -> image !== null){
            $contentType = "image";
            $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imageName = time().'.'.$request->image->extension();
            $request->image->storeAs('post_images', $imageName, 'public');
            $content = 'post_images/' . $imageName;
        } else {
            $contentType = null;
            $content = null;
        }
     Post::create([
            'user_id' => Auth::id(),
            'shares' => 0,
            'post_type' => $contentType,
            'content_type' => $content,
            'content' => $request -> content,
            'hashtags' => $request -> hashtags,
        ]);
        return redirect()->route("dashboard");
    }
}
