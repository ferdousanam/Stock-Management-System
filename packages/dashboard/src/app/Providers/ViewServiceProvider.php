<?php

namespace Anam\Dashboard\App\Providers;

use Anam\Dashboard\App\Http\View\Composers\SystemComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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
        View::composer('admin::layouts.app', SystemComposer::class);
    }
}
