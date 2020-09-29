<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Admin\Admin' => 'App\Policies\Admin\AdminPolicy',
        'App\Models\Client' => 'App\Policies\Admin\ClientPolicy',
        'App\Models\Institution' => 'App\Policies\Admin\InstitutionPolicy',
        'App\Models\User' => 'App\Policies\Admin\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
