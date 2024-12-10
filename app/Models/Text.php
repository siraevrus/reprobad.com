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
 * @property string|null $content
 * @property int $active
 * @method static Builder<static>|Text active()
 * @method static Builder<static>|Text newModelQuery()
 * @method static Builder<static>|Text newQuery()
 * @method static Builder<static>|Text query()
 * @method static Builder<static>|Text whereActive($value)
 * @method static Builder<static>|Text whereAlias($value)
 * @method static Builder<static>|Text whereContent($value)
 * @method static Builder<static>|Text whereCreatedAt($value)
 * @method static Builder<static>|Text whereDescription($value)
 * @method static Builder<static>|Text whereId($value)
 * @method static Builder<static>|Text whereTitle($value)
 * @method static Builder<static>|Text whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Text extends Model
{
    protected $table = 'text';

    protected $guarded = ['id'];

    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }
}
