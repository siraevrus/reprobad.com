<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $fillable = [
        'page_type',
        'page_id',
        'title',
        'description',
        'keywords',
        'og_title',
        'og_description',
        'og_image',
    ];

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