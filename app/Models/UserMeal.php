<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserMeal extends Model
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
        return $this->hasMany(UserMealItem::class, 'user_meal_id');
    }

}
