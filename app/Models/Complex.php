<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complex extends Model
{
    protected $table = 'complex';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function products()
    {
        return $this->hasMany(Product::class, 'complex_id', 'id');
    }
}
