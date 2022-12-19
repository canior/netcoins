<?php

namespace App\Services\Requests;

abstract class AbstractCoinPriceRequest extends AbstractCryptoRequest
{
    protected string $currency;
    protected array $cryptoCurrencies;

    public function __construct(string $currency, array $cryptoCurrencies) {
        $this->currency = $currency;
        $this->cryptoCurrencies = $cryptoCurrencies;
    }
}
