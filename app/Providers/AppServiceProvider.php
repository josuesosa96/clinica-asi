<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\File;
use App\Observers\FileObserver;

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
      File::observe(FileObserver::class);
    }
}
