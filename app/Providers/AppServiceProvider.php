<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('isPemilik', function($user){
            return $user->role->peran == 'Pemilik';
        });

        Gate::define('isProdusen', function($user){
            return $user->role->peran == 'Produsen';
        });

        Gate::define('isDistributor', function($user){
            return $user->role->peran == 'Distributor';
        });
        Gate::define('isSuperadmin', function($user){
            return $user->role->peran == 'Superadmin';
        });
        Gate::define('isPemilikProdusen', function ($user){
            if ($user->role->peran == 'Pemilik') {
                return true;
            } elseif($user->role->peran == 'Produsen') {
                return true;
            } else {
                return false;
            }
        });
        Gate::define('isPemilikSuperadmin', function ($user){
            if ($user->role->peran == 'Pemilik') {
                return true;
            } elseif($user->role->peran == 'Superadmin') {
                return true;
            } else {
                return false;
            }
        });
        Gate::define('isPemilikSuperadminProdusen', function ($user){
            if ($user->role->peran == 'Pemilik') {
                return true;
            } elseif($user->role->peran == 'Superadmin') {
                return true;
            } elseif($user->role->peran == 'Produsen') {
                return true;
            } else {
                return false;
            }
        });
    }
}
