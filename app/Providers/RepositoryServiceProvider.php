<?php

namespace App\Providers;

use App\Repositories\Technoscape\TechnoscapeRepository;
use App\Repositories\Technoscape\TechnoscapeRepositoryImplement;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TechnoscapeRepository::class, TechnoscapeRepositoryImplement::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
