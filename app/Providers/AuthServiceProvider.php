<?php

namespace App\Providers;

// use App\Models\MangaoStaticUseradmin;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
use Auth;

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

        Gate::define('isSuperAdmin', function($admin = null){
            $admin=  Auth::guard('admin')->user();
            return $admin->user_type == 'super_admin' ? Response::allow()
                : Response::deny('You must be an administrator.');
        });

        Gate::define('isCityAdmin', function($city_admin = null){
            $city_admin =  Auth::guard('city_admin')->user();
            return $city_admin->user_type == 'city_admin' ? Response::allow()
                : Response::deny('You must be an city admin.');
        });

        Gate::define('isVendorAdmin', function($vendor = null){
            $vendor=  Auth::guard('vendor')->user();
            return $vendor->user_type == 'vendor' ? Response::allow()
                : Response::deny('You must be an vendor.');
        });


        Gate::define('isVendorGrocery', function($vendor = null){
            $vendor=  Auth::guard('vendor')->user();
            return $vendor->category_type == 'Grocery' ? Response::allow()
                : Response::deny('You must be an grocery vendor.');
        });

        
        Gate::define('isVendorRestaurant', function($vendor = null){
            $vendor=  Auth::guard('vendor')->user();
            return $vendor->category_type == 'Restaurant' ? Response::allow()
                : Response::deny('You must be an grocery vendor.');
        });        

        
    }
}
