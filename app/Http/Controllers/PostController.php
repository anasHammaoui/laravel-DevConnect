<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use Jorenvh\Share\Share;

class PostController extends Controller
{
    public function index(Request $request){
        $searchPost = $request -> searchPost;
        $sorting = $request -> sort;
    //    sort users
    if (!$sorting || $sorting === 'recent'){
        $allPosts = Post::where('content', 'like', '%' . $searchPost . '%')
                ->orWhereHas('hashtags', function($q) use ($searchPost) {
                $q->where('name', $searchPost);
                })
        ->latest()
        ->paginate(5);
    } elseif($sorting === 'top'){
        $allPosts = Post::where('content', 'like', '%' . $searchPost . '%')
        ->orWhereHas('hashtags', function($q) use ($searchPost) {
        $q->where('name', $searchPost);
        })
        ->withCount('likes')
        ->orderBy('likes_count', 'desc')
        ->paginate(5);
    }
        $allUsers = User::paginate(5);
        // $shareButtons = \Share::page(
        //     url('/post'),
        //     'here is the title'
        // )->facebook()->twitter()->linkedin();
        // dd($allPosts);
        return view("dashboard", ["allPosts"=>$allPosts, "connections" => Auth::user() -> connections, "allUsers" => $allUsers]);
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
        $post = Post::create([
            'user_id' => Auth::id(),
            'shares' => 0,
            'post_type' => $contentType,
            'content_type' => $content,
            'content' => $request -> content,
        ]);
        $tags = $request -> hashtags ? explode(',', $request -> hashtags) : [];
        $tagsId = [];
        foreach($tags as $tag){
            $tag = Hashtag::firstOrCreate(['name' => $tag]);
            array_push($tagsId, $tag);
        }
        $push = $post -> hashtags() -> attach($tagsId);
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
