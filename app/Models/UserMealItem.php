<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserMealItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_meal_id'
    ];

    public function user_meal(): BelongsTo
    {
        return $this->belongsTo(UserMeal::class);
    }

    public function meal(): BelongsTo
    {
        return $this->belongsTo(Meal::class);
    }
}
