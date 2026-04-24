<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\AdminPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Define admin gate
        Gate::define('admin', function (User $user) {
            return (bool) $user->is_admin;
        });

        // Define admin policy methods
        Gate::define('view-admin-dashboard', function (User $user) {
            return (bool) $user->is_admin;
        });

        Gate::define('view-contact-messages', function (User $user) {
            return (bool) $user->is_admin;
        });

        Gate::define('delete-contact-message', function (User $user) {
            return (bool) $user->is_admin;
        });
    }
}
