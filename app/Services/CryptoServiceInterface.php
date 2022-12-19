<?php

namespace App\Services;

use App\Services\Responses\CryptoCoinMarketResponse;
use App\Services\Responses\CryptoCoinPriceResponse;

interface CryptoServiceInterface
{
    /**
     * @param string $currency
     * @param array $cryptoCurrencies
     * @return CryptoCoinPriceResponse[]
     */
    public function getPriceByCoin(string $currency, array $cryptoCurrencies = []): array;

    /**
     * @param string $currency
     * @param array $cryptoCurrencies
     * @return CryptoCoinMarketResponse[]
     */
    public function getCoinsMarkets(string $currency, array $cryptoCurrencies = []): array;
}
