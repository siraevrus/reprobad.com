<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];

    protected $with = ['complex'];

    public function complex()
    {
        return $this->belongsTo(Complex::class, 'complex_id', 'id')
            ->withDefault();
    }
}
