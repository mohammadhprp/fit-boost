<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserWorkoutItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_workout_id'
    ];

    public function user_workout(): BelongsTo
    {
        return $this->belongsTo(UserWorkout::class);
    }

    public function workout(): BelongsTo
    {
        return $this->belongsTo(Workout::class);
    }
}
