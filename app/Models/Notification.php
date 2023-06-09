<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'notify_at',
        'read_at'
    ];

    protected $casts = [
        'notify_at' => 'datetime',
        'read_at' => 'datetime'
    ];

    public function notificationable(): MorphTo
    {
        return $this->morphTo();
    }
}
