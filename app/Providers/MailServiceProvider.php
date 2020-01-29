<?php

namespace App\Providers;

use App\Service;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (! App::runningInConsole()) {
            if (Schema::hasTable('services')) {
                $service = Service::first();
                if ($service) {
                    config([
                        'mail' => [
                            'driver' => $service->service,
                            'host' => $service->credentials['host'],
                            'port' => $service->credentials['port'],
                            'username' => $service->credentials['username'],
                            'password' => $service->credentials['password'],
                            'from' => [
                                'address' => 'emir@gmail.com',
                                'name' => 'Emir',
                            ],
                        ],
                    ]);
                }
            }
        }
    }
}
