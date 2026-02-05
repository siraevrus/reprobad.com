<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $table = 'test_results';

    protected $guarded = ['id'];

    protected $casts = [
        'answers' => 'array',
        'results' => 'array',
    ];

    protected $appends = ['date'];

    public function getDateAttribute()
    {
        return $this->created_at->format('d.m.Y H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
