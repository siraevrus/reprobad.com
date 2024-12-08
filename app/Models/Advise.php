<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advise extends Model
{
    protected $table = 'advises';

    protected $guarded = ['id'];

    protected $appends = [
        'published_at'
    ];

    public function getPublishedAtAttribute()
    {
        return $this->created_at->format('d.m.Y');
    }
}
