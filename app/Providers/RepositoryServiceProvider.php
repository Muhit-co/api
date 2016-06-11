<?php

namespace Muhit\Providers;

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
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Muhit\Repositories\Announcement\AnnouncementRepositoryInterface',
            'Muhit\Repositories\Announcement\AnnouncementRepository');

        $this->app->bind(
            'Muhit\Repositories\Hood\HoodRepositoryInterface',
            'Muhit\Repositories\Hood\HoodRepository');

        $this->app->bind(
            'Muhit\Repositories\Tag\TagRepositoryInterface',
            'Muhit\Repositories\Tag\TagRepository');

        $this->app->bind(
            'Muhit\Repositories\Muhtar\MuhtarRepositoryInterface',
            'Muhit\Repositories\Muhtar\MuhtarRepository');

        // Member - Admin
        $this->app->bind(
            'Muhit\Repositories\Admin\AdminRepositoryInterface',
            'Muhit\Repositories\Admin\AdminRepository');

        // User
        $this->app->bind(
            'Muhit\Repositories\User\UserRepositoryInterface',
            'Muhit\Repositories\User\UserRepository');
    }
}
