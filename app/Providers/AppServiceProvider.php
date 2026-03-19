<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (App::environment('production')) {
            URL::forceScheme('https');
        }

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Подтверждение Email адреса')
                ->greeting('Приветствую!')
                ->line('Пожалуйста, нажмите кнопку ниже, чтобы подтвердить свой адрес электронной почты.')
                ->action('Подтвердить Email адрес', $url)
                ->line('Если вы не создавали учетную запись, игонорируйте данное письмо.');
        });
    }
}
