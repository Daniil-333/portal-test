<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Video;


use App\MoonShine\Resources\Category\CategoryResource;
use App\MoonShine\Resources\Tag\TagResource;
use Illuminate\Database\Eloquent\Model;
use App\Models\Video;
use App\MoonShine\Resources\Video\Pages\VideoIndexPage;
use App\MoonShine\Resources\Video\Pages\VideoFormPage;
use App\MoonShine\Resources\Video\Pages\VideoDetailPage;

use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Field;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\Hidden;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Video, VideoIndexPage, VideoFormPage, VideoDetailPage>
 */
class VideoResource extends ModelResource
{
    protected string $model = Video::class;

    protected string $title = 'Видео';

    protected string $column = 'title';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            VideoIndexPage::class,
            VideoFormPage::class,
            VideoDetailPage::class,
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Название', 'title'),
                Hidden::make('slug', 'slug'),
                Text::make('Краткое описание', 'short_desc'),
                TinyMce::make('Полное описание', 'description'),

                File::make('Видео или картинка', 'file_name')
                    ->disk(moonshineConfig()->getDisk())
                    ->dir('media')
                    ->allowedExtensions(['jpg', 'png', 'jpeg', 'webp', 'avi', 'mp4', 'mkv'])
                    ->removable(),

                BelongsTo::make(
                    'Категория',
                    'category',
                    resource: CategoryResource::class
                )->searchable()
                ->nullable(),
                BelongsToMany::make(
                    'Теги',
                    'tags',
                    resource: TagResource::class
                )->selectMode()
            ]),
        ];
    }
}
