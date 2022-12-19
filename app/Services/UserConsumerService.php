<?php

namespace App\Services;

use App\Http\Resources\UserConsumerResource;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

class UserConsumerService
{
    private CryptoServiceInterface $cryptoService;

    public function __construct(CryptoServiceInterface  $cryptoService) {
        $this->cryptoService = $cryptoService;
    }

    /**
     * @throws \Exception
     */
    public function consume(string $currency): AnonymousResourceCollection
    {
        $supportedCryptoCurrencies = config('crypto.currencies');

        try {
            $coinsMarkets = $this->cryptoService->getCoinsMarkets($currency, $supportedCryptoCurrencies);
            $coinsPrices = $this->cryptoService->getPriceByCoin($currency, $supportedCryptoCurrencies);
        } catch (\Exception $e) {
            Log::error('crypto provider is broken', $e->getTrace());
            throw new ConnectionException('user consumer api is down');
        }

        $coinsMarketsResource = [];
        foreach ($coinsMarkets as $coinMarket) {
            $coinsMarketsResource[$coinMarket->getCryptoCurrency()] = [
                'currency' => $coinMarket->getCurrency(),
                'high24' => $coinMarket->getHigh24(),
                'low24' => $coinMarket->getLow24(),
            ];
        }

        $coinsPricesResource = [];
        foreach ($coinsPrices as $coinsPrice) {
            $coinsPricesResource[$coinsPrice->getCryptoCurrency()] = [
                'currency' => $coinsPrice->getCurrency(),
                'current_price' => $coinsPrice->getCurrentPrice(),
            ];
        }

        $resource = [];
        foreach ($supportedCryptoCurrencies as $supportedCryptoCurrency) {
            $resource[] = [
                'crypto_currency' => $supportedCryptoCurrency,
                'currency' => $currency,
                'high24' => $coinsMarketsResource[$supportedCryptoCurrency]['high24'],
                'low24' => $coinsMarketsResource[$supportedCryptoCurrency]['low24'],
                'current_price' => $coinsPricesResource[$supportedCryptoCurrency]['current_price'],
            ];
        }

        return UserConsumerResource::collection($resource);
    }
}
