<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.debug')) {
            error_reporting(E_ALL & ~E_USER_DEPRECATED);
        } else {
            error_reporting(0);
        }

        if (!strpos(request()->path(), 'api/broadcasting/auth')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
            // redirect(str_replace('http', 'https', request()->url()));
        }
    }
}
