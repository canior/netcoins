<?php

namespace App\Services\Requests;


abstract class AbstractCoinsMarketsRequest extends AbstractCryptoRequest
{
    protected string $currency;
    protected array $cryptoCurrencies;

    public function __construct(string $currency, array $cryptoCurrencies) {
        $this->currency = $currency;
        $this->cryptoCurrencies = $cryptoCurrencies;
    }

}
