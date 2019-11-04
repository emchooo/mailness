<?php

namespace App\Providers;

use App\Service;
use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\Facades\Schema;
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
        if(Schema::hasTable('services')) {
            $service = Service::first();
            config([
                'services'  => [
                    'ses'   => [
                        'key'   => $service->key,
                        'secret'    => $service->secret,
                        'region'    => $service->region
                    ]
                ]
            ]);
        }
    }
}
