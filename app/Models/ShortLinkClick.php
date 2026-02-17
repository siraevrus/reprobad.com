<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShortLinkClick extends Model
{
    protected $table = 'short_link_clicks';

    public $timestamps = false;

    protected $fillable = [
        'short_link_id',
        'clicked_at',
        'referer',
        'user_agent',
        'ip',
    ];

    protected $casts = [
        'clicked_at' => 'datetime',
    ];

    public function shortLink(): BelongsTo
    {
        return $this->belongsTo(ShortLink::class);
    }
}
