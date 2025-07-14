<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $casts = [
        'ingredients' => 'array',
        'steps' => 'array',
        'nutrients' => 'array',
        'times' => 'array',
    ];
}
