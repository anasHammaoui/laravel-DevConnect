<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $allPosts = Post::with("hashtags") -> get();
        // dd($allPosts);
        return view("dashboard", ["allPosts"=>$allPosts]);
    }
}
