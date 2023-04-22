<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'remind_at'
    ];

    protected $casts = [
        'remind_at' => 'datetime'
    ];

    public function reminderable()
    {
        return $this->morphTo();
    }
}
