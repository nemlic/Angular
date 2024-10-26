<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class attendant extends Model
{
    
        // Specify the fillable fields to allow mass assignment
    protected $fillable = [
        'id_number',
        'firstName',
        'surname',
        'lastName',
        'phone',
        'email',
        'station',
        'nextofKin',
        'contactofKin'
    ];
    
}
