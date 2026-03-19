<?php

namespace App\MoonShine\Pages;

use MoonShine\Laravel\Pages\LoginPage;
use App\MoonShine\Layouts\LoginLayout;

class LoginPageCustom extends LoginPage
{
    protected ?string $layout = LoginLayout::class;
}
