<?php

namespace App\Providers;

use App\Service;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        if (Schema::hasTable('services')) {
            $service = Service::first();
            if ($service) {
                config([
                    'services'  => [
                        'ses'   => [
                            'key'   => $service->key,
                            'secret'    => $service->secret,
                            'region'    => $service->region,
                        ],
                    ],
                ]);
            }
        }
    }
}
