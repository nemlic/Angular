<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'user_id', 'content'];

    // Define relationship with post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Define relationship with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
