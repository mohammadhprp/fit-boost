<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'description',
        'remind_at',
        'is_completed'
    ];

    protected $casts = [
        'remind_at' => 'datetime',
        'is_completed' => 'bool'
    ];

    public function reminderable(): MorphTo
    {
        return $this->morphTo();
    }
}
