<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TestResultField extends Model
{
    protected $table = 'test_result_fields';

    protected $guarded = ['id'];

    protected $casts = [
        'active' => 'boolean',
        'block_number' => 'integer',
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('active', true);
    }

    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('order', 'asc')->orderBy('field_number', 'asc');
    }

    public function scopeByFieldNumber(Builder $query, int $fieldNumber): void
    {
        $query->where('field_number', $fieldNumber);
    }
}
