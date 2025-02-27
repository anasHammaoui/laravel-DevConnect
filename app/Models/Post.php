<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'content',
        'image',
        'code',
        'link',
        'likes',
        'shares',
    ];
    public function user(){
        return $this -> belongsTo(User::class);
    }
    public function hashtags(){
        return $this -> belongsToMany(Hashtag::class, "post_hashtags");
    }
}
