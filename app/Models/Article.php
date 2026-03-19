<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'short_desc',
        'description',
        'image'
    ];

    protected $appends = ['image_path'];

    protected static function booted()
    {
        static::saved(function ($article) {
            if ($article->wasChanged('image') && $article->image) {
                $currentValue = $article->image;

                if (str_contains($currentValue, '/')) {
                    $article->image = basename($currentValue);
                    $article->saveQuietly();
                }
            }
        });

        static::created(function ($article) {
            if ($article->image && str_contains($article->image, '/')) {
                $article->image = basename($article->image);
                $article->saveQuietly();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected function slug(): Attribute
    {
        return Attribute::make(
            set: function (?string $value, array $attributes) {
                return Str::slug($attributes['title']);
            },
        );
    }

    public function getImagePathAttribute(): ?string
    {
        return $this->image ? asset('storage/media/article/' . $this->image) : null;
    }
}
