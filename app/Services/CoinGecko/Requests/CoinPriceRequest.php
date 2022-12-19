<?php

namespace App\Services\CoinGecko\Requests;

use App\Services\Requests\AbstractCoinPriceRequest;

class CoinPriceRequest extends AbstractCoinPriceRequest
{
    public function toArray(): array
    {
        return [
            'ids' => implode(',', $this->cryptoCurrencies),
            'vs_currencies' => $this->currency,
        ];
    }
}
