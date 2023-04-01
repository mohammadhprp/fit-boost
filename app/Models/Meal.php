<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'weekday',
        'calories',
    ];

    public function plan_items()
    {
        return $this->morphMany(PlanItem::class, 'plan_itemable');
    }
}
