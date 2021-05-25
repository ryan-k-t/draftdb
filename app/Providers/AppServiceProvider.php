<?php

namespace App\Providers;

use App\Models\Ranking;
use App\Models\SeasonalPlayer;
use App\Observers\RankingObserver;
use App\Observers\SeasonalPlayerObserver;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        SeasonalPlayer::observe( SeasonalPlayerObserver::class );
        Ranking::observe( RankingObserver::class );
    }
}
