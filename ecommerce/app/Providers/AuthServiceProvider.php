<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Cart;
use App\Models\User;
use App\Policies\CartPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Cart::class => CartPolicy::class, // Map the Cart model to the CartPolicy
        // Add other models and their policies here
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        // Define a custom Gate for admin-only access
        Gate::define('admin-only', function (User $user) {
            return $user->role === 'admin';
        });
    }
}
