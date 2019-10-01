<?php

namespace App\Providers;

use App\Repositories\Contracts\{
    ReportRepository
};

use App\Repositories\Eloquent\{
    EloquentReportRepository
};

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ReportRepository::class, EloquentReportRepository::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
