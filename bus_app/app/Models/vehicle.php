<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vehicle extends Model
{
    protected $fillable = [
        'registration_number',
        'make',
        'model',
        'mfg_year',
        'color',
        'capacity',
        'cc',
        'fuel'
    ];
}
