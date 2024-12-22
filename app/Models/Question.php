<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = ['id'];

    protected $with = ['article'];

    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
