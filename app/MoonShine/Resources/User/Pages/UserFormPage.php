<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\User\Pages;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password as PasswordRule;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use App\MoonShine\Resources\User\UserResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Fields\ID;
use Throwable;


/**
 * @extends FormPage<UserResource>
 */
class UserFormPage extends FormPage
{
    protected string $title = 'Добавить';

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->isItemExists() ? 'Редактировать' : $this->title;
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
//    protected function fields(): iterable
//    {
//        return [
//            Box::make([
//                ID::make()
//            ]),
//        ];
//    }

    protected function buttons(): ListOf
    {
        return parent::buttons();
    }

    protected function formButtons(): ListOf
    {
        return parent::formButtons();
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique($item->getOriginal()::class)->ignoreModel($item->getOriginal()),
            ],
            'password' => [
                ...$item->getKey() !== null ? ['sometimes', 'nullable'] : ['required'],
                PasswordRule::defaults(),
                'confirmed',
            ],
        ];
    }

    /**
     * @param  FormBuilder  $component
     *
     * @return FormBuilder
     */
    protected function modifyFormComponent(FormBuilderContract $component): FormBuilderContract
    {
        return $component;
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function topLayer(): array
    {
        return [
            ...parent::topLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer()
        ];
    }
}
