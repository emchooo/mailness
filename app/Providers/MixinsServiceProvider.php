<?php

namespace App\Providers;

use App\Mixins\StringableMixins;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Stringable;

class MixinsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Stringable::mixin(new StringableMixins);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
