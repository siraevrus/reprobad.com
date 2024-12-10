<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $title
 * @property string $alias
 * @property string|null $description
 * @property string $content
 * @property string|null $time
 * @property string|null $category
 * @property string|null $image
 * @property string|null $icon
 * @property int $active
 * @property-read mixed $published_at
 * @method static Builder<static>|Article active()
 * @method static Builder<static>|Article newModelQuery()
 * @method static Builder<static>|Article newQuery()
 * @method static Builder<static>|Article query()
 * @method static Builder<static>|Article whereActive($value)
 * @method static Builder<static>|Article whereAlias($value)
 * @method static Builder<static>|Article whereCategory($value)
 * @method static Builder<static>|Article whereContent($value)
 * @method static Builder<static>|Article whereCreatedAt($value)
 * @method static Builder<static>|Article whereDescription($value)
 * @method static Builder<static>|Article whereIcon($value)
 * @method static Builder<static>|Article whereId($value)
 * @method static Builder<static>|Article whereImage($value)
 * @method static Builder<static>|Article whereTime($value)
 * @method static Builder<static>|Article whereTitle($value)
 * @method static Builder<static>|Article whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Article extends Model
{
    protected $table = 'articles';

    protected $guarded = ['id'];

    protected $appends = [
        'published_at'
    ];

    public function getPublishedAtAttribute()
    {
        return $this->created_at->format('d.m.Y');
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }
}
