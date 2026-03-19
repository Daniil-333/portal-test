<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use App\MoonShine\Resources\MoonShineUser\MoonShineUserResource;
use App\MoonShine\Resources\MoonShineUserRole\MoonShineUserRoleResource;
use App\MoonShine\Resources\User\UserResource;
use App\MoonShine\Resources\Video\VideoResource;
use App\MoonShine\Resources\Category\CategoryResource;
use App\MoonShine\Resources\Tag\TagResource;
use App\MoonShine\Resources\WhiteListUser\WhiteListUserResource;
use App\MoonShine\Resources\Article\ArticleResource;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  CoreContract<MoonShineConfigurator>  $core
     */
    public function boot(CoreContract $core): void
    {
        $core
            ->resources([
                MoonShineUserResource::class,
                MoonShineUserRoleResource::class,
                UserResource::class,
                VideoResource::class,
                CategoryResource::class,
                TagResource::class,
                WhiteListUserResource::class,
                ArticleResource::class,
            ])
            ->pages([
                ...$core->getConfig()->getPages(),
            ])
        ;
    }
}
