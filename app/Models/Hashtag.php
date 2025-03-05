<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    protected $fillable = ['name'];
    public function posts(){
        return $this -> belongsToMany(Post::class, 'posts_tags', 'hashtag_id', 'post_id');
    }
}
