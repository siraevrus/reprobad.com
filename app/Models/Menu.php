<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';

    protected $casts = [
        'menu_data' => 'array',
    ];
    
    protected $guarded = ['id'];

    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }

    public function scopeSorted(Builder $query): void
    {
        $query->orderBy('day', 'ASC');
    }
}
