<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Customer extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'member_since',
        'is_active',
    ];
}
