<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserWorkout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'start_at',
        'end_at'
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(UserWorkoutItem::class, 'user_workout_id');
    }

    public function progress()
    {
        return $this->hasMany(WorkoutProgress::class);
    }


    protected static function booted()
    {
        static::addGlobalScope('by_user', function (Builder $builder) {
            $builder->where('user_id', auth()->id());
        });
    }

}
