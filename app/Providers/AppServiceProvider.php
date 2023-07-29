<?php

namespace App\Providers;

use App\Services\Auth\AuthService;
use App\Services\Auth\AuthServiceImplement;
use App\Services\Group\GroupService;
use App\Services\Group\GroupServiceImplement;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function provides(): array
    {
        return [
            AuthService::class,
            GroupService::class
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->services();
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

    private function services()
    {
        $this->app->singleton(AuthService::class, AuthServiceImplement::class);
        $this->app->singleton(GroupService::class, GroupServiceImplement::class);
    }
}
