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
 * @property string|null $description
 * @property string $alias
 * @property string|null $image
 * @property string|null $content
 * @property int $active
 * @property string|null $time
 * @property string|null $category
 * @property string|null $icon
 * @property-read mixed $published_at
 * @method static Builder<static>|Advise active()
 * @method static Builder<static>|Advise newModelQuery()
 * @method static Builder<static>|Advise newQuery()
 * @method static Builder<static>|Advise query()
 * @method static Builder<static>|Advise whereActive($value)
 * @method static Builder<static>|Advise whereAlias($value)
 * @method static Builder<static>|Advise whereCategory($value)
 * @method static Builder<static>|Advise whereContent($value)
 * @method static Builder<static>|Advise whereCreatedAt($value)
 * @method static Builder<static>|Advise whereDescription($value)
 * @method static Builder<static>|Advise whereIcon($value)
 * @method static Builder<static>|Advise whereId($value)
 * @method static Builder<static>|Advise whereImage($value)
 * @method static Builder<static>|Advise whereTime($value)
 * @method static Builder<static>|Advise whereTitle($value)
 * @method static Builder<static>|Advise whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }
}
