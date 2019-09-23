<?php

namespace App\Modules\DanfeExpo\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        // dd($this->app);
        $this->app->bind(
            App\Modules\DanfeExpo\Interfaces\DanfeStorageInterface::class,
            App\Modules\DanfeExpo\Repositories\DanfeStorageRepository::class

        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
