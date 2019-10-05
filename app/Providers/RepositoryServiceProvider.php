<?php

namespace App\Providers;

use App\Repositories\Contracts\{
    AdminRepository,
    FollowReportRepository,
    FollowReportTagRepository,
    FollowUserRepository,
    ReportCommentRepository,
    ReportRepository,
    ReportTagRepository,
    UserRepository
};

use App\Repositories\Eloquent\{
    EloquentAdminRepository,
    EloquentFollowReportRepository,
    EloquentFollowReportTagRepository,
    EloquentFollowUserRepository,
    EloquentReportCommentRepository,
    EloquentReportRepository,
    EloquentReportTagRepository,
    EloquentUserRepository
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
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(ReportTagRepository::class, EloquentReportTagRepository::class);
        $this->app->bind(ReportCommentRepository::class, EloquentReportCommentRepository::class);
        $this->app->bind(FollowUserRepository::class, EloquentFollowUserRepository::class);
        $this->app->bind(FollowReportTagRepository::class, EloquentFollowReportTagRepository::class);
        $this->app->bind(FollowReportRepository::class, EloquentFollowReportRepository::class);
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
