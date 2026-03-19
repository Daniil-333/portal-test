<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\WhiteListUser;

use Illuminate\Database\Eloquent\Model;
use App\Models\WhiteListUser;
use App\MoonShine\Resources\WhiteListUser\Pages\WhiteListUserIndexPage;
use App\MoonShine\Resources\WhiteListUser\Pages\WhiteListUserFormPage;
use App\MoonShine\Resources\WhiteListUser\Pages\WhiteListUserDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends ModelResource<WhiteListUser, WhiteListUserIndexPage, WhiteListUserFormPage, WhiteListUserDetailPage>
 */
class WhiteListUserResource extends ModelResource
{
    protected string $model = WhiteListUser::class;

    protected string $title = 'Белый список пользователей';

    protected string $column = 'email';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            WhiteListUserIndexPage::class,
            WhiteListUserFormPage::class,
            WhiteListUserDetailPage::class,
        ];
    }

    protected function activeActions(): ListOf
    {
        return parent::activeActions()
            ->except(Action::VIEW);
    }
}
