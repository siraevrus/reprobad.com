<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{
    protected $table = 'test_questions';

    protected $guarded = ['id'];

    protected $casts = [
        'answers' => 'array',
        'active' => 'boolean',
        'block_number' => 'integer',
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('active', true);
    }

    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('order', 'asc');
    }
}
