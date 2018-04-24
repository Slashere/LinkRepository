<?php

namespace App\Providers;

use App\Entity\Link;
use App\Entity\User;
use App\Extensions\AccessTokenGuard;
use App\Extensions\TokenToUserProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerPostPolicies();
        $this->registerApiPostPolicies();

        Auth::extend('access_token', function ($app, $name, array $config) {
            // automatically build the DI, put it as reference
            $userProvider = app(TokenToUserProvider::class);
            $request = app('request');
            return new AccessTokenGuard($userProvider, $request, $config);
        });
    }

    public function registerPostPolicies()
    {
        Gate::define('create-link', function (User $user) {
            return $user->hasAccess(['create-link']);
        });

        Gate::define('update-link', function (User $user, Link $link) {
            return $user->hasAccess(['update-link']) or $user->id == $link->user_id;
        });

        Gate::define('delete-link', function (User $user, Link $link) {
            return $user->hasAccess(['delete-link']) or $user->id == $link->user_id;
        });

        Gate::define('update-user', function (User $user, User $user2) {
            return $user->hasAccess(['update-user']) or $user->id == $user2->id;
        });

        Gate::define('update-user-status-and-role', function (User $user) {
            return $user->hasAccess(['update-user-status-and-role']);
        });

        Gate::define('delete-user', function (User $user) {
            return $user->hasAccess(['delete-user']);
        });

        Gate::define('show-private-link', function (User $user, Link $link) {
            return $user->hasAccess(['show-private-link']) or $user->id == $link->user_id;
        });

        Gate::define('list-private-links', function (User $user) {
            return $user->hasAccess(['list-private-links']);
        });

    }

    public function registerApiPostPolicies()
    {
        Gate::define('api-create-link', function (User $user) {
            return $user->hasAccess(['create-link']);
        });

        Gate::define('api-update-link', function (User $user, Link $link) {
            return $user->id == $link->user_id;
        });

        Gate::define('api-delete-link', function (User $user, Link $link) {
            return $user->id == $link->user_id;
        });

        Gate::define('api-show-private-link', function (User $user, Link $link) {
            return $user->id == $link->user_id;
        });

        Gate::define('api-update-user', function (User $user, User $user2) {
            return $user->id == $user2->id;
        });

        Gate::define('api-delete-user', function (User $user, User $user2) {
            return $user->id == $user2->id;
        });
    }
}
