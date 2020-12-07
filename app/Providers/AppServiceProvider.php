<?php

namespace App\Providers;

use Illuminate\Http\Client\Request;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\AdminRepositoryInterface;
use App\Repositories\Eloquent\AdminRepository;
use App\Repositories\EloquentRepositoryInterface;

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
        \App\Models\Client::observe(\App\Observers\ClientObserver::class);
        \App\Models\User::observe(\App\Observers\UserObserver::class);
        \App\Models\Institution::observe(\App\Observers\InstitutionObserver::class);
        \App\Models\Content::observe(\App\Observers\ContentObserver::class);
        \App\Models\ContentLive::observe(\App\Observers\ContentLiveObserver::class);

        //$this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        //$this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
//dd($this->app->request);
$url = $this->app->request->getHost();
$protocol = 'http://'; //( ) ? ‘https://’ : ‘http://’;
$addressUrl = $protocol.$url;

        config()->set('app.url', $addressUrl);

    }
}
