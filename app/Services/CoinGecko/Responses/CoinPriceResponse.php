<?php

namespace App\Services\CoinGecko\Responses;

use App\Services\Responses\CryptoCoinPriceResponse;

class CoinPriceResponse extends CryptoCoinPriceResponse
{
    public function __construct(string $cryptoCurrency, string $currency, array $response) {
        parent::__construct($cryptoCurrency, $currency, $response);
    }
}
