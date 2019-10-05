<?php

namespace App\Providers;

use App\Repositories\Contracts\{
    AdminRepository, ReportCommentRepository, ReportRepository, ReportTagRepository
};

use App\Repositories\Eloquent\{
    EloquentAdminRepository, EloquentReportCommentRepository, EloquentReportRepository, EloquentReportTagRepository
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
        $this->app->bind(AdminRepository::class, EloquentAdminRepository::class);
        $this->app->bind(ReportTagRepository::class, EloquentReportTagRepository::class);
        $this->app->bind(ReportCommentRepository::class, EloquentReportCommentRepository::class);
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
