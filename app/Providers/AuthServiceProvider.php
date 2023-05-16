<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Gate::define('isResto', function($user) {
        return $user->role == 'RESTO';
        });
        Gate::define('isKurir', function($user) {
        return $user->role == 'KURIR';
        });
        Gate::define('isKonsumen', function($user) {
        return $user->role == 'KONSUMEN';
        });
    }
}
