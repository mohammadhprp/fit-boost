<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id'
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function plan_itemable()
    {
        return $this->morphTo();
    }

}
