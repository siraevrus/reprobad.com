<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property string $title
 * @property string $alias
 * @property string|null $subtitle
 * @property string|null $content
 * @property string|null $image_left
 * @property string|null $image_right
 * @property string|null $title_left
 * @property string|null $title_right
 * @property string|null $description
 * @property string|null $color
 * @property integer|null $sort
 * @property int $active
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static Builder<static>|Complex active()
 * @method static Builder<static>|Complex newModelQuery()
 * @method static Builder<static>|Complex newQuery()
 * @method static Builder<static>|Complex query()
 * @method static Builder<static>|Complex whereActive($value)
 * @method static Builder<static>|Complex whereAlias($value)
 * @method static Builder<static>|Complex whereColor($value)
 * @method static Builder<static>|Complex whereContent($value)
 * @method static Builder<static>|Complex whereDescription($value)
 * @method static Builder<static>|Complex whereId($value)
 * @method static Builder<static>|Complex whereImageLeft($value)
 * @method static Builder<static>|Complex whereImageRight($value)
 * @method static Builder<static>|Complex whereSubtitle($value)
 * @method static Builder<static>|Complex whereTitle($value)
 * @method static Builder<static>|Complex whereTitleLeft($value)
 * @method static Builder<static>|Complex whereTitleRight($value)
 * @mixin \Eloquent
 */
class Complex extends Model
{
    protected $table = 'complex';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function products()
    {
        return $this->hasMany(Product::class, 'complex_id', 'id');
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1)
            ->orderBy('sort', 'ASC');
    }

    public function scopeSorted(Builder $query): void
    {
        $query->orderBy('sort', 'ASC');
    }
}
