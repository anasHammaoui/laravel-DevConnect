<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validate = $request -> validate([
           'comment' => 'required',
           'post_id' => 'required'
       ]);
        Comment::create([
              'content' => $validate['comment'],
              'user_id' => Auth::id(),
              'post_id' => $validate['post_id']
         ]);
   
         return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    Comment::find($id)->delete();
    return redirect()->back();
    }
}
