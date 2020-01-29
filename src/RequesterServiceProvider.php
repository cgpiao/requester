<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RequesterServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
       $this->publishes(__DIR__ . '/../config/requester.php', config_path('requester.php'));
    }
}
