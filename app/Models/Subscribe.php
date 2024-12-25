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
 * @property string|null $logo
 * @property string|null $content
 * @property string|null $address
 * @property string|null $dates
 * @property int $active
 * @property string|null $category
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $file
 * @property-read mixed $published_at
 * @method static Builder<static>|Event active()
 * @method static Builder<static>|Event newModelQuery()
 * @method static Builder<static>|Event newQuery()
 * @method static Builder<static>|Event query()
 * @method static Builder<static>|Event whereActive($value)
 * @method static Builder<static>|Event whereAddress($value)
 * @method static Builder<static>|Event whereAlias($value)
 * @method static Builder<static>|Event whereCategory($value)
 * @method static Builder<static>|Event whereContent($value)
 * @method static Builder<static>|Event whereCreatedAt($value)
 * @method static Builder<static>|Event whereDates($value)
 * @method static Builder<static>|Event whereDescription($value)
 * @method static Builder<static>|Event whereEmail($value)
 * @method static Builder<static>|Event whereFile($value)
 * @method static Builder<static>|Event whereId($value)
 * @method static Builder<static>|Event whereImage($value)
 * @method static Builder<static>|Event whereLogo($value)
 * @method static Builder<static>|Event wherePhone($value)
 * @method static Builder<static>|Event whereTitle($value)
 * @method static Builder<static>|Event whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Subscribe extends Model
{
    protected $table = 'subscribers';

    protected $guarded = ['id'];
}
