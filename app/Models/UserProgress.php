<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'weight',
        'height',
        'body_fat',
        'notes'
    ];

    protected $casts = [
        'body_fat' => 'double',
        'weight' => 'double',
        'height' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shares(): HasMany
    {
        return $this->hasMany(ShareProgress::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('by_user', function (Builder $builder) {
            $builder->where('user_id', auth()->id());
        });
    }
}
