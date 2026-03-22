<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    protected $fillable = [
        'customer_id',
        'registration',
        'make',
        'model',
        'year',
        'color',
        'engine_number',
        'chassis_number',
        'last_service_at',
    ];
}
