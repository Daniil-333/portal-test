<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Models\Video;
use App\Models\WhiteListUser;
use App\MoonShine\Resources\Category\CategoryResource;
use App\MoonShine\Resources\Tag\TagResource;
use App\MoonShine\Resources\User\UserResource;
use App\MoonShine\Resources\Video\VideoResource;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\ColorManager\Palettes\PurplePalette;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Contracts\ColorManager\PaletteContract;
use MoonShine\MenuManager\MenuDivider;
use MoonShine\MenuManager\MenuItem;
use MoonShine\UI\Components\Layout\Footer;
use App\MoonShine\Resources\WhiteListUser\WhiteListUserResource;
use App\MoonShine\Resources\Article\ArticleResource;

final class MoonShineLayout extends AppLayout
{
    /**
     * @var null|class-string<PaletteContract>
     */
    protected ?string $palette = PurplePalette::class;

    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    protected function menu(): array
    {
        $menu = [];

        if(auth()->user()->isSuperUser()) {
            $menu = [
                ...parent::menu(),
                MenuDivider::make(),
            ];
        }

        return $this->getMenuItems($menu);
    }

    /**
     * @param ColorManager $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);

        // $colorManager->primary('#00000');
    }

    protected function getFooterCopyright(): string
    {
        return '&copy; 2026 created by Daniel Yakovlev';
    }

    protected function getFooterComponent(): Footer
    {
        return parent::getFooterComponent()->menu([]);
    }

    protected function getLogo(bool $small = false): string
    {
        return '/vendor/moonshine/logo-small.png';
    }

    private function getMenuItems($menu): array
    {
        return array_merge($menu, [
            MenuItem::make(WhiteListUserResource::class, 'Белый список')
                ->icon('')
                ->badge(WhiteListUser::count()),
            MenuItem::make(UserResource::class, 'Пользователи')
                ->icon('users')
                ->badge(User::count()),
            MenuItem::make(VideoResource::class, 'Видео')
                ->icon('video-camera')
                ->badge(fn() => Video::count()),
            MenuItem::make(CategoryResource::class, 'Категории')
                ->icon('document-duplicate')
                ->badge(fn() => Category::count()),
            MenuItem::make(TagResource::class, 'Тэги')
                ->icon('tag')
                ->badge(fn() => Tag::count()),
            MenuItem::make(ArticleResource::class, 'Статьи')
                ->icon('document')
                ->badge(fn() => Article::count()),
        ]);
    }
}
