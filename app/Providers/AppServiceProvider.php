<?php

namespace App\Providers;

use App\Services\ThirdParty\Todo\TodoAPIInterface;
use App\Services\ThirdParty\Todo\TypicodeAPIService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TodoAPIInterface::class, TypicodeAPIService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
