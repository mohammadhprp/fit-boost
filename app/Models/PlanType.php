<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanType extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    public const WORKOUT = 1;
    public const MEAL = 2;
}
