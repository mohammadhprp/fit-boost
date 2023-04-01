<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'weekday',
        'calories',
    ];

    public function user_meal_item(): BelongsTo
    {
        return $this->belongsTo(UserMealItem::class);
    }
}
