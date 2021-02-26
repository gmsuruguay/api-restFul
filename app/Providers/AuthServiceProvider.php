<?php

namespace App\Providers;

use Carbon\Carbon;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
    /* public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
        //Passport::personalAccessTokensExpireIn(now()->addHours(1));
        Passport::tokensExpireIn(Carbon::now()->addMinutes(1));
       
    } */

    public function boot()
    {
        $this->registerPolicies();
        // Configuración tiempo de expiración
        Passport::routes(function($router){
            $router->forAccessTokens();
            $router->forPersonalAccessTokens();
            $router->forTransientTokens();
        });        
       
        Passport::tokensExpireIn(Carbon::now()->addMinutes(1));
        Passport::RefreshTokensExpireIn(Carbon::now()->addDays(100));
    }


}
