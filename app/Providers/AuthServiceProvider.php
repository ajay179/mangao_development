<?php

namespace App\Providers;

use App\Models\MangaoStaticUseradmin;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
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

        //
        Gate::define('isSuperAdmin', function($user){

            echo "ajay";
            // $admin=  Auth::guard('admin')->user();

            // echo $admin->user_type;
            // return $admin->user_type == 'super_admin';
        });

        // Gate::define('isSuperAdmin', function($user){
        //     echo $user;
        //     return $user->user_type == 'super_admin';
        // });
    }
}
