<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Config newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Config newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Config query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Config whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Config whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Config whereValue($value)
 * @mixin \Eloquent
 */
class Config extends Model
{
    protected $table = 'config';

    protected $guarded = ['id'];

    public $timestamps = false;
}
