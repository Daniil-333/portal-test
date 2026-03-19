<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\MoonShine\Resources\User\Pages\UserIndexPage;
use App\MoonShine\Resources\User\Pages\UserFormPage;
use App\MoonShine\Resources\User\Pages\UserDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Password;
use MoonShine\UI\Fields\PasswordRepeat;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<User, UserIndexPage, UserFormPage, UserDetailPage>
 */
class UserResource extends ModelResource
{
    protected string $model = User::class;

    protected string $title = 'Пользователи';

    protected string $column = 'email';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            UserIndexPage::class,
            UserFormPage::class,
            UserDetailPage::class,
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Grid::make([
                Column::make([
                    Box::make('Основная ингформация', [
                        ID::make(),
                        Text::make('Имя', 'name'),
                        Email::make('E-mail', 'email'),
                    ])
                ])->columnSpan(8),

                Column::make([
                    Box::make('Смена пароля', [
                        Collapse::make('Изменить', [
                            Password::make('Пароль', 'password'),
                            PasswordRepeat::make('Попторите пароль', 'password_confirmation'),
                        ])
                    ])
                ])->columnSpan(4),
            ])
        ];
    }
}
