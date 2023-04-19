<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ShareProgress extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'user_progress_id',
        'url',
        'title',
        'notes'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function progress(): BelongsTo
    {
        return $this->belongsTo(UserProgress::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(ShareProgressVisit::class, 'share_progress_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->url = Str::random(6);
        });
    }

    protected static function booted()
    {
        static::addGlobalScope('by_user', function (Builder $builder) {
            $builder->where('user_id', auth()->id());
        });
    }
}
