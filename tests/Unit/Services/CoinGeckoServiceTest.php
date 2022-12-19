<?php

namespace Tests\Unit\Services;

use App\Services\CoinGecko\CoinGeckoService;
use Tests\TestCase;

class CoinGeckoServiceTest extends TestCase
{
    public function testSuccessfullyGetPriceByCoin() {

        $currency = config('crypto.default_vs_currency');

        /**
         * @var CoinGeckoService $service
         */
        $service = $this->app->make(CoinGeckoService::class);
        $coinsPrices = $service->getPriceByCoin($currency, config('crypto.currencies'));

        foreach (config('crypto.currencies') as $i => $cryptoCurrency) {
            $this->assertEquals($currency, $coinsPrices[$i]->getCurrency());
            $this->assertTrue(in_array($coinsPrices[$i]->getCryptoCurrency(), config('crypto.currencies')));
            $this->assertGreaterThan(0, $coinsPrices[$i]->getCurrentPrice());
        }
    }


    public function testSuccessfullyGetCoinsMarkets() {

        $currency = config('crypto.default_vs_currency');

        /**
         * @var CoinGeckoService $service
         */
        $service = $this->app->make(CoinGeckoService::class);
        $coinsMarkets = $service->getCoinsMarkets($currency, config('crypto.currencies'));

        foreach (config('crypto.currencies') as $i => $cryptoCurrency) {
            $this->assertEquals($currency, $coinsMarkets[$i]->getCurrency());
            $this->assertTrue(in_array($coinsMarkets[$i]->getCryptoCurrency(), config('crypto.currencies')));
            $this->assertGreaterThan(0, $coinsMarkets[$i]->getHigh24());
            $this->assertGreaterThan(0, $coinsMarkets[$i]->getLow24());
        }
    }
}
