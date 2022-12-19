<?php

namespace Tests\Unit\Services;

use App\Services\CryptoServiceInterface;
use App\Services\Responses\CryptoCoinMarketResponse;
use App\Services\Responses\CryptoCoinPriceResponse;
use App\Services\UserConsumerService;
use Faker\Generator;
use Illuminate\Http\Client\ConnectionException;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class UserConsumerServiceTest extends TestCase
{
    private Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = fake();
    }

    /**
     * @throws \Exception
     */
    public function testSuccessfullyGetResult() {

        $coinsPrices = [];
        $coinsMarkets = [];

        foreach(config('crypto.currencies') as $supportedCryptoCurrency) {
            $coinsPrices[] = new CryptoCoinPriceResponse($supportedCryptoCurrency, 'usd', [
                'usd' => $this->faker->numberBetween(1, 99999)
            ]);

            $coinsMarkets[] = new CryptoCoinMarketResponse($supportedCryptoCurrency, 'usd', [
                'high_24h' => $this->faker->numberBetween(1, 99999),
                'low_24h' => $this->faker->numberBetween(1, 99999),
            ]);
        }

        $cryptoService = Mockery::mock(CryptoServiceInterface::class,
            function (MockInterface $mock) use ($coinsPrices, $coinsMarkets) {
                $mock->shouldReceive('getCoinsMarkets')->once()->andReturn($coinsMarkets);
                $mock->shouldReceive('getPriceByCoin')->once()->andReturn($coinsPrices);
        });

        $userConsumerService = new UserConsumerService($cryptoService);
        $collection = $userConsumerService->consume('usd');

        foreach ($collection->response()->getData()->data as $i => $cryptoCurrencyData) {
            $this->assertEquals($coinsPrices[$i]->getCryptoCurrency(), $cryptoCurrencyData->crypto_currency);
            $this->assertEquals($coinsPrices[$i]->getCurrency(), $cryptoCurrencyData->currency);
            $this->assertEquals($coinsPrices[$i]->getCurrentPrice(), $cryptoCurrencyData->current_price);

            $this->assertEquals($coinsMarkets[$i]->getCryptoCurrency(), $cryptoCurrencyData->crypto_currency);
            $this->assertEquals($coinsMarkets[$i]->getCurrency(), $cryptoCurrencyData->currency);
            $this->assertEquals($coinsMarkets[$i]->getLow24(), $cryptoCurrencyData->low24);
            $this->assertEquals($coinsMarkets[$i]->getHigh24(), $cryptoCurrencyData->high24);
        }

    }

    public function testCryptoProviderGetCoinsMarketsLostConnectionAndThrowsException() {
        $cryptoService = Mockery::mock(CryptoServiceInterface::class,
            function (MockInterface $mock) {
                $mock->shouldReceive('getCoinsMarkets')->once()->andThrow(new ConnectionException());
            }
        );

        $userConsumerService = new UserConsumerService($cryptoService);
        try {
            $userConsumerService->consume('usd');
            $this->fail();
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
    }


    public function testCryptoProviderGetPriceByCoinLostConnectionAndThrowsException() {
        $cryptoService = Mockery::mock(CryptoServiceInterface::class,
            function (MockInterface $mock) {
                $mock->shouldReceive('getCoinsMarkets')->once()->andReturn([]);
                $mock->shouldReceive('getPriceByCoin')->once()->andThrow(new ConnectionException());
            }
        );

        $userConsumerService = new UserConsumerService($cryptoService);
        try {
            $userConsumerService->consume('usd');
            $this->fail();
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
    }
}
