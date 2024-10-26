<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empregistration extends Model
{
    protected $table = 'empregistrations';
    protected $primaryKey ='id';
    protected $fillable =[
        'name',
        'address',
        'phone',
    ];
}
