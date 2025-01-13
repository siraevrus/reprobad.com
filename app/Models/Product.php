<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $text
 * @property string|null $content
 * @property string|null $image
 * @property string|null $images
 * @property string|null $photo
 * @property string|null $image_left
 * @property string|null $image_right
 * @property string|null $title_left
 * @property string|null $title_right
 * @property string|null $logo
 * @property string|null $includes
 * @property string|null $usage
 * @property string|null $about
 * @property string|null $subtitle
 * @property string|null $alias
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property string|null $color
 * @property int|null $complex_id
 * @property integer|null $sort
 * @property int $active
 * @property-read \App\Models\Complex|null $complex
 * @method static Builder<static>|Product active()
 * @method static Builder<static>|Product newModelQuery()
 * @method static Builder<static>|Product newQuery()
 * @method static Builder<static>|Product query()
 * @method static Builder<static>|Product whereAbout($value)
 * @method static Builder<static>|Product whereActive($value)
 * @method static Builder<static>|Product whereAlias($value)
 * @method static Builder<static>|Product whereColor($value)
 * @method static Builder<static>|Product whereComplexId($value)
 * @method static Builder<static>|Product whereContent($value)
 * @method static Builder<static>|Product whereCreatedAt($value)
 * @method static Builder<static>|Product whereDescription($value)
 * @method static Builder<static>|Product whereId($value)
 * @method static Builder<static>|Product whereImage($value)
 * @method static Builder<static>|Product whereImageLeft($value)
 * @method static Builder<static>|Product whereImageRight($value)
 * @method static Builder<static>|Product whereIncludes($value)
 * @method static Builder<static>|Product whereLogo($value)
 * @method static Builder<static>|Product wherePhoto($value)
 * @method static Builder<static>|Product whereSubtitle($value)
 * @method static Builder<static>|Product whereText($value)
 * @method static Builder<static>|Product whereTitle($value)
 * @method static Builder<static>|Product whereTitleLeft($value)
 * @method static Builder<static>|Product whereTitleRight($value)
 * @method static Builder<static>|Product whereUpdatedAt($value)
 * @method static Builder<static>|Product whereUsage($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'images' => 'json'
    ];

    protected $with = ['complex'];

    public function complex()
    {
        return $this->belongsTo(Complex::class, 'complex_id', 'id')
            ->withDefault();
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
