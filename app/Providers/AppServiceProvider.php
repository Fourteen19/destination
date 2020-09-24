<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\EloquentRepositoryInterface; 
use App\Repositories\AdminRepositoryInterface; 
use App\Repositories\Eloquent\AdminRepository; 
use App\Repositories\Eloquent\BaseRepository; 



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

        \App\Models\Admin\Admin::observe(\App\Observers\Admin\AdminObserver::class);

        //$this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        //$this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
    }
}
