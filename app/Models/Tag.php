<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Tag extends Model
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
     * Связь Многие-ко-многим между Tag и Video (через таблицу videos_tags)
     * @return BelongsToMany
     */
    public function videos(): BelongsToMany
    {
        return $this->belongsToMany(Video::class);
    }

    public static function getAllForSelect()
    {
        return self::all()->pluck('title', 'id')->toArray();
    }
}
