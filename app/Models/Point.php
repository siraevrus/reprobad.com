<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $guarded = ['id'];

    protected $appends = ['coordinates'];

    public function getCoordinatesAttribute(): array
    {
        return explode(',', $this->attributes['coords']);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }
}
