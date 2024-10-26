<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    protected $fillable = [
        'id_number',
        'firstName',
        'surname',
        'lastName',
        'phone',
        'email'
    ];
}
