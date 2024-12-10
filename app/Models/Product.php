<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];

    public function complex(): void
    {
        $this->belongsTo(Complex::class, 'complex_id', 'id');
    }
}
