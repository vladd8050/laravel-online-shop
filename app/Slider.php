<?php

namespace AutoKit;

use Illuminate\Database\Eloquent\Model;

/**
 * AutoKit\Slider
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $category_id
 * @property string $img
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\AutoKit\Slider whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\AutoKit\Slider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\AutoKit\Slider whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\AutoKit\Slider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\AutoKit\Slider whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\AutoKit\Slider whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\AutoKit\Slider whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Slider extends Model
{
    protected $fillable = [
        'title', 'description', 'category_id', 'img'
    ];

    public function getImgAttribute(string $value): string
    {
        return '/img/carousel/' . $value;
    }
}
