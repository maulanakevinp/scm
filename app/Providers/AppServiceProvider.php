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
            return $user->role->role == 'Kepala';
        });

        Gate::define('isProduksi', function($user){
            return $user->role->role == 'Produksi';
        });

        Gate::define('isDistributor', function($user){
            return $user->role->role == 'Distributor';
        });
    }
}
