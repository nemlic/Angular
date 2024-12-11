<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Charity extends Model
{
    protected $table = 'charities';

    protected $fillable = [
        'name',
        'description',
        'photo_url',
    ];
    //Relationship with donations
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
     // Relationship with posts
     public function posts()
     {
         return $this->hasMany(Post::class);
     }
}
