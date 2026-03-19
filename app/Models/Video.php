<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'short_desc',
        'description',
        'file_name',
        'category_id'
    ];

    protected $appends = ['tags_list', 'file_path'];

    protected static function booted()
    {
        static::saved(function ($video) {
            if ($video->wasChanged('file_name') && $video->file_name) {
                $currentValue = $video->file_name;

                // Если значение содержит путь, обрезаем
                if (str_contains($currentValue, '/')) {
                    $video->file_name = basename($currentValue);
                    $video->saveQuietly();
                }
            }
        });

        static::created(function ($video) {
            if ($video->file_name && str_contains($video->file_name, '/')) {
                $video->file_name = basename($video->file_name);
                $video->saveQuietly();
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

    public function getTagsListAttribute()
    {
        return $this->tags->pluck('title')->implode(', ');
    }

    public function getFilePathAttribute()
    {
        return $this->file_name ? asset('storage/media/' . $this->file_name) : null;
    }

    /**
     * Связь Один-ко-многим между Video & Category
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Связь Многие-ко-многим между Video & Tag (через таблицу videos_tags)
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
