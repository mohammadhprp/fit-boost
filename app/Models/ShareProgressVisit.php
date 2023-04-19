<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShareProgressVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'share_progress_id',
        'ip_address',
        'operating_system',
        'operating_system_version',
        'browser'
    ];

    protected $casts = [
        'visited_at' => 'datetime'
    ];

    public function share_progress(): BelongsTo
    {
        return $this->belongsTo(ShareProgress::class);
    }
}
