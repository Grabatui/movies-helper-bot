<?php

namespace App\Telegram;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->app->singleton(Gate::class, function () {
            return new Gate(
                new Client(['base_uri' => 'https://api.telegram.org/']),
                app('log')
            );
        });
    }
}
