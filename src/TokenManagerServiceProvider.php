<?php
namespace BaoTran\TokenManager;

use Illuminate\Support\ServiceProvider;

class TokenManagerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(TokenManager::class, function ($app) {
            return new TokenManager(config('app.key'));
        });

        $this->app->singleton(SessionManager::class, function ($app) {
            return new SessionManager();
        });
    }
}
