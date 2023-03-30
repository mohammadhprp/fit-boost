<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OTP extends Model
{
    use HasFactory;

    public const SMS_CHANNEL = 1;
    public const EMAIL_CHANNEL = 2;

    protected $fillable = [
        'request_id',
        'receiver',
        'receiver_channel',
        'password',
        'expired_at'
    ];

    protected $casts = [
        'receiver_channel' => 'integer',
        'expired_at' => 'datetime'
    ];


    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->request_id = Str::uuid();
        });
        self::updating(function ($model) {
            $model->request_id = Str::uuid();
        });
    }
}
