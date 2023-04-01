<?php

namespace App\Models;

use App\Enums\WorkoutLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'raps',
        'sets',
        'weekday',
        'level',
    ];

    protected $casts = ['level' => WorkoutLevel::class];

}
