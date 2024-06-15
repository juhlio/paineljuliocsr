<?php

namespace App\Providers;

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
        Gate::define('salacontrole', function ($user) {
            return $user->roles->contains('id', 2) || $user->roles->contains('id', 1);
        });
        Gate::define('comercial', function ($user) {
            return $user->roles->contains('id', 3) || $user->roles->contains('id', 1);
        });
        Gate::define('estoque', function ($user) {
            return $user->roles->contains('id', 4) || $user->roles->contains('id', 1);
        });
        Gate::define('enel', function ($user) {
            return $user->roles->contains('id', 5) || $user->roles->contains('id', 1);
        });
        Gate::define('compras', function ($user) {
            return $user->roles->contains('id', 6) || $user->roles->contains('id', 1);
        });

    }
}
