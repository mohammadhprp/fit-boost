<?php

namespace App\Models;

use App\Enums\WorkoutLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function user_workout_item(): BelongsTo
    {
        return $this->belongsTo(UserWorkoutItem::class);
    }

}
