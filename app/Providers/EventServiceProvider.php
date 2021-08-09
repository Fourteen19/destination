<?php

namespace App\Providers;

use App\Events\LoginHistory;
use App\Events\ArticleHistory;
use App\Events\ClientEventHistory;
use App\Events\ClientVacancyHistory;
use Illuminate\Support\Facades\Event;
use App\Listeners\StoreArticleHistory;
use Illuminate\Auth\Events\Registered;
use App\Listeners\StoreUserLoginHistory;
use App\Listeners\StoreClientEventHistory;
use App\Listeners\StoreClientVacancyHistory;
use App\Listeners\StoreClientLoginTotalHistory;
use App\Listeners\StoreArticleTotalStatsHistory;
use App\Listeners\StoreArticleMonthlyStatsHistory;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        LoginHistory::class => [
            StoreUserLoginHistory::class,
            StoreClientLoginTotalHistory::class,
        ],
        ClientEventHistory::class => [
            StoreClientEventHistory::class,
        ],
        ClientVacancyHistory::class => [
            StoreClientVacancyHistory::class,
        ],
        ArticleHistory::class => [
            StoreArticleHistory::class,
            StoreArticleMonthlyStatsHistory::class,
            StoreArticleTotalStatsHistory::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
