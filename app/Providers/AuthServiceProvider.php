<?php

namespace App\Providers;

use App\Custom\Authentication\ErpUserProvider;
use App\Custom\Authentication\Md5Hasher;
use App\Custom\Authentication\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('admin_users', function ($app, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\UserProvider...
            $hasher = app(Md5Hasher::class);
            return new ErpUserProvider($hasher, User::class);
        });
    }
}
