<?php

namespace App\Services\CoinGecko\Responses;

use App\Services\Responses\CryptoCoinMarketResponse;

class CoinMarketResponse extends CryptoCoinMarketResponse
{
    public function __construct(string $cryptoCurrency, string $currency, array $response)
    {
        parent::__construct($cryptoCurrency, $currency, $response);
    }
}

