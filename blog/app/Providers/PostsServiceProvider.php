<?php

namespace App\Providers;

use App\Services\PostsService;
use Illuminate\Support\ServiceProvider;

class PostsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PostsService::class, function ($app) {
            return new PostsService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
