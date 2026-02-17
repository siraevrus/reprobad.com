<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShortLink extends Model
{
    protected $table = 'short_links';

    protected $fillable = [
        'long_url',
        'short_code',
        'name',
        'clicks_count',
    ];

    protected $casts = [
        'clicks_count' => 'integer',
    ];

    public function getShortUrlAttribute(): string
    {
        return rtrim(config('app.url'), '/') . '/s/' . $this->short_code;
    }

    public function clicks(): HasMany
    {
        return $this->hasMany(ShortLinkClick::class);
    }
}
