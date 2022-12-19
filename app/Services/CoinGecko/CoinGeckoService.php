<?php

namespace App\Services\CoinGecko;

use App\Services\CoinGecko\Requests\CoinPriceRequest;
use App\Services\CoinGecko\Requests\CoinsMarketsRequest;
use App\Services\CoinGecko\Responses\CoinMarketResponse;
use App\Services\CoinGecko\Responses\CoinPriceResponse;
use App\Services\CryptoServiceInterface;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Implements
 * https://www.coingecko.com/en/api/documentation
 */
class CoinGeckoService implements CryptoServiceInterface
{
    public function getPriceByCoin(string $currency, array $cryptoCurrencies = []): array
    {
        $coinPriceRequest = new CoinPriceRequest($currency, $cryptoCurrencies);
        $payload = $coinPriceRequest->toArray();

        Log::info('coin price request: ' .  json_encode($payload));

        $response = Http::retry(3, 100, function ($exception) {
            return $exception instanceof ConnectionException;
        })->get(config('crypto.CoinGecko.endpoint') . '/simple/price', $payload);

        $responseArray = $response->json();

        Log::info('coin price response:  ' .  json_encode($responseArray));

        $coinsPrices = [];
        foreach ($responseArray as $key => $item) {
            $coinsPrices[] = new CoinPriceResponse($key, $currency, $item);
        }

        return $coinsPrices;
    }

    public function getCoinsMarkets(string $currency, array $cryptoCurrencies = []): array
    {
        $coinsMarketsRequest = new CoinsMarketsRequest($currency, $cryptoCurrencies);
        $payload = $coinsMarketsRequest->toArray();

        Log::info('coins markets request: ' .  json_encode($payload));

        $response = Http::retry(3, 100, function ($exception) {
            return $exception instanceof ConnectionException;
        })->get(config('crypto.CoinGecko.endpoint') . '/coins/markets', $payload);

        $responseArray = $response->json();

        Log::info('coins markets response:  ' .  json_encode($responseArray));

        $coinsMarkets = [];
        foreach ($response->json() as $item) {
            $coinsMarkets[] = new CoinMarketResponse($item['id'], $currency, $item);
        }

        return $coinsMarkets;
    }

}
