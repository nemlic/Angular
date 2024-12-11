<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['charity_id', 'title', 'content'];

    // Define relationship with charity
    public function charity()
    {
        return $this->belongsTo(Charity::class);
    }

    // Define relationship with likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Define relationship with spam reports
    public function spamReports()
    {
        return $this->hasMany(SpamReport::class);
    }

    // Define relationship with comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
