<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'charity',
        'total_donations',
        'donation_count',
    ];
}
