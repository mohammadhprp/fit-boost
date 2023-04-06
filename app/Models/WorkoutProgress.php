<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkoutProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_workout_id',
        'title',
        'description',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];


    public function user_workout(): BelongsTo
    {
        return $this->belongsTo(UserWorkout::class);
    }
}
