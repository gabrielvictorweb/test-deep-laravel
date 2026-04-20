<?php

namespace Infra\Providers;

use Domain\Contracts\Auth0UserProfileSyncInterface;
use Domain\Contracts\Auth0UserRegistrationInterface;
use Domain\Contracts\ProductImageStorageInterface;
use Domain\Contracts\ProductRepositoryInterface;
use Domain\Contracts\UserAvatarStorageInterface;
use Domain\Contracts\UserRepositoryInterface;
use Infra\Repositories\Auth0UserProfileSyncRepository;
use Infra\Repositories\Auth0UserRegistrationRepository;
use Infra\Repositories\EloquentProductRepository;
use Infra\Repositories\EloquentUserRepository;
use Infra\Repositories\S3ProductImageStorageRepository;
use Infra\Repositories\S3UserAvatarStorageRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, EloquentProductRepository::class);
        $this->app->bind(ProductImageStorageInterface::class, S3ProductImageStorageRepository::class);
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(UserAvatarStorageInterface::class, S3UserAvatarStorageRepository::class);
        $this->app->bind(Auth0UserProfileSyncInterface::class, Auth0UserProfileSyncRepository::class);
        $this->app->bind(Auth0UserRegistrationInterface::class, Auth0UserRegistrationRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
