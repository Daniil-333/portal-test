<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug'
    ];

    protected function slug(): Attribute
    {
        return Attribute::make(
            set: function (?string $value, array $attributes) {
                return Str::slug($attributes['title']);
            },
        );
    }

    /**
     * Связь Один-ко-многим между Category & Video
     * @return HasMany
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    public static function getAllForSelect()
    {
        return self::all()->pluck('title', 'id')->toArray();
    }
}
