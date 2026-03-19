<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="200" alt="Laravel Logo"></a></p>

# <p align="center">Тестовый шаблон по размещению видео&nbsp;и&nbsp;статей.</p>

## Стек 

[Laravel](https://laravel.com/docs/12.x) - 
[Inertia](https://inertiajs.com/docs/v2/getting-started/index) - 
[Vue](https://vuejs.org/guide/introduction.html) - 
[TypeScript](https://www.typescriptlang.org/docs/handbook/enums.html)

Библиотеки Backend:
[Laravel Data](https://spatie.be/docs/laravel-data/v4/introduction)

Библиотеки Frontend:
[PrimeVue](https://primevue.org/) ***
[Heroicons](https://heroicons.com/) ***
[TailwindCSS](https://tailwindcss.com/) ***
[Zod](https://zod.dev/)

Общие
[Momentum Trail](https://github.com/lepikhinb/momentum-trail)

Breadcrumbs:  
(https://github.com/diglactic/laravel-breadcrumbs) 
(https://github.com/robertboes/inertia-breadcrumbs)

StateManager: [Pinia](https://pinia.vuejs.org/)  
Админка: [Moonshine](https://getmoonshine.app/en/docs/4.x)

___

## Админка

Адрес: `/admin`

Создать ресурс: ``php artisan moonshine:resource `имя_модели` ``

___

## Вход

Логин / пароль: `test@test.ru / qwerty12345678`

___

### Команды

#### Создать объект с данными:
    php artisan make:data Client
#### Сгенерировать объявления маршрутов TypeScript:
    php artisan trail:generate
#### Сгенерировать типы данных TypeScript:
    php artisan typescript:transform --format

Генерация объявления маршрутов и типов данных происходит автоматически за счёт настройки плагина (watch) в vite.config.js.

#### Сгенерировать Модель данных для TypeScript:
    php artisan make:data Video

___

### Docker (<a href="https://laravel.com/docs/12.x/sail#main-content">Documentation</a>)
##### Добавить в .zshrc или .bashrc и перезапустить терминал:
    alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
    alias sail='docker compose -f compose.yaml exec laravel_sty php'

Запуск:

    sail up -d

Остановка:

    sail stop
