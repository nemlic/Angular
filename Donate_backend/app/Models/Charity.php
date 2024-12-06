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

}
