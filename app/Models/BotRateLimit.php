<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BotRateLimit extends Model
{
    protected $table = 'bot_rate_limits';
    
    protected $guarded = ['id'];

    protected $fillable = [
        'ip_address',
        'date',
        'count'
    ];

    public $timestamps = true;
}
