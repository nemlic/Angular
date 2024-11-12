<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $table ='registrations';

    protected $primaryKey='id';
    protected $fillable=[
        'name',
        'location',
        'phone'
    ];
}
