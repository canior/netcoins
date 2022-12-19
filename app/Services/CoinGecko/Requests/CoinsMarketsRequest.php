<?php

namespace App\Services\CoinGecko\Requests;

use App\Services\Requests\AbstractCoinsMarketsRequest;

class CoinsMarketsRequest extends AbstractCoinsMarketsRequest
{
    public function toArray(): array
    {
        return [
            'vs_currency' => $this->currency,
            'ids' => implode(',' ,  $this->cryptoCurrencies),
        ];
    }
}
