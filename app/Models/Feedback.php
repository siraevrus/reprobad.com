<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    protected $guarded = ['id'];

    protected $appends = ['date'];

    public function getDateAttribute()
    {
        return $this->created_at->format('d.m.Y H:i:s');
    }
}
