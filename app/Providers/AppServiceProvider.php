<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            $view = strstr($url, 'api/', true) . substr(strstr($url, 'api/'), 4);
            return (new MailMessage)
                ->subject('Verify Email Address')
                ->line('Please click the button below to verify your email address')
                ->action('Verify Email Address', $view)
                ->line('If you did not create an account, no further action is required.');
        });
    }
}
