<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;

class PostController extends Controller
{
    public function index(){
        $allPosts = Post::latest() -> paginate(5) ;
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
    public function update(Request $request,$id){
        $validation = $request -> validate([
            "content" => "required|min:5",
        ]);
        $post = Post::find($id);
        $post->content = $request -> content;
        $post->save();
        return redirect()->route("dashboard");
    }
    public function destroy($id){
        $post = Post::find($id);
        if ($post -> post_type === 'image' && $post -> content_type !== null){
            Storage::disk('public') -> delete($post -> content_type);
        }
        $post -> delete();
        return redirect() -> back() -> with('post_deleted','Post deleted successfully');
    }
    // mark as read function
    public function markasread(){
        auth() -> user() -> unreadNotifications -> markAsRead();
        return redirect() -> back();
    }
}
