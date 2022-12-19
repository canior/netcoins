<?php

namespace App\Providers;

use App\Services\CoinGecko\CoinGeckoService;
use App\Services\CryptoServiceInterface;
use Illuminate\Support\ServiceProvider;

class CryptoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     * @throws \Exception
     */
    public function register()
    {
        $provider = $this->app['config']['crypto.provider'];
        if ($provider === 'CoinGecko') {
            $this->app->bind(CryptoServiceInterface::class, CoinGeckoService::class);
        } else {
            throw new \Exception('no crypto provider available');
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
