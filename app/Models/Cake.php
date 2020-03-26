<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cake extends Model
{
    protected $table = 'cake';

    protected $fillable = [
        'title', 
        'description', 
        'rating', 
        'image',
    ];
}