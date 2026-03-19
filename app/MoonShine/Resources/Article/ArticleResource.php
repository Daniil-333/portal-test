<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Article;


use App\Models\Article;
use App\MoonShine\Resources\Article\Pages\ArticleIndexPage;
use App\MoonShine\Resources\Article\Pages\ArticleFormPage;
use App\MoonShine\Resources\Article\Pages\ArticleDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\Hidden;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Article, ArticleIndexPage, ArticleFormPage, ArticleDetailPage>
 */
class ArticleResource extends ModelResource
{
    protected string $model = Article::class;

    protected string $title = 'Статьи';

    protected string $column = 'title';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            ArticleIndexPage::class,
            ArticleFormPage::class,
            ArticleDetailPage::class,
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
                Text::make('Время прочтения', 'read_time'),
                TinyMce::make('Полное описание', 'description'),

                File::make('Картинка', 'image')
                    ->disk(moonshineConfig()->getDisk())
                    ->dir('media/article')
                    ->allowedExtensions(['jpg', 'jpeg', 'png', 'webp'])
                    ->removable(),
            ]),
        ];
    }
}
