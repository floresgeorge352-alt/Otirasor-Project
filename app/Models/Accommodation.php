<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    protected $fillable = [
        'name',
        'type',
        'description',
        'price',
        'capacity',
        'image',
        'status',
    ];
}