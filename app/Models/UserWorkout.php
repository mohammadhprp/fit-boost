<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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

    public function progress(): HasMany
    {
        return $this->hasMany(WorkoutProgress::class);
    }

    public function reminders(): MorphMany
    {
        return $this->morphMany(Reminder::class, 'reminderable');
    }


    protected static function booted(): void
    {
        static::addGlobalScope('by_user', function (Builder $builder) {
            $builder->where('user_id', auth()->id());
        });
    }

}
