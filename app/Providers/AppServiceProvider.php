<?php

namespace App\Providers;

use App\Repositories as Repositories;
use App\Repositories\Interfaces as Interfaces;
use App\Services as Services;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(Interfaces\CategoryRepositoryInterface::class, Repositories\CategoryRepository::class);
        $this->app->bind(Services\CategoryService::class, function ($app) {
            return new Services\CategoryService($app->make(Interfaces\CategoryRepositoryInterface::class));
        });

        $this->app->bind(Interfaces\AuthRepositoryInterface::class, Repositories\AuthRepository::class);
        $this->app->bind(Services\AuthService::class, function ($app) {
            return new Services\AuthService($app->make(Interfaces\AuthRepositoryInterface::class));
        });

        $this->app->bind(Interfaces\UserRepositoryInterface::class, Repositories\UserRepository::class);
        $this->app->bind(Services\UserService::class, function ($app) {
            return new Services\UserService($app->make(Interfaces\UserRepositoryInterface::class));
        });

        $this->app->bind(Interfaces\CommentRepositoryInterface::class, Repositories\CommentRepository::class);
        $this->app->bind(Services\CommentService::class, function ($app) {
            return new Services\CommentService($app->make(Interfaces\CommentRepositoryInterface::class));
        });

        $this->app->bind(Interfaces\MarkRepositoryInterface::class, Repositories\MarkRepository::class);
        $this->app->bind(Services\MarkService::class, function ($app) {
            return new Services\MarkService($app->make(Interfaces\MarkRepositoryInterface::class));
        });

        $this->app->bind(Interfaces\PlanRepositoryInterface::class, Repositories\PlanRepository::class);
        $this->app->bind(Services\PlanService::class, function ($app) {
            return new Services\PlanService($app->make(Interfaces\PlanRepositoryInterface::class));
        });
    }

    public function boot(): void
    {
        //
    }
}
