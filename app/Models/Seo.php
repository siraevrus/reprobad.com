<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{

    protected $table = 'seo';

    protected $guarded = ['id'];

    public function page()
    {
        return $this->morphTo('page', 'page_type', 'page_id');
    }

    public function getPageAttribute()
    {
        $modelClass = "App\\Models\\{$this->page_type}";
        if (class_exists($modelClass)) {
            return $modelClass::find($this->page_id);
        }
        return null;
    }
} 