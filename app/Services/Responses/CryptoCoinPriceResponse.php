<?php

namespace App\Services\Responses;

class CryptoCoinPriceResponse extends AbstractCryptoResponse
{
    protected string $cryptoCurrency;

    protected string $currency;

    protected float $currentPrice;

    public function __construct(string $cryptoCurrency, string $currency, array $response)
    {
        $this->cryptoCurrency = $cryptoCurrency;
        $this->currency = $currency;
        $this->currentPrice = $response[$currency];
    }

    /**
     * @return string
     */
    public function getCryptoCurrency(): string
    {
        return $this->cryptoCurrency;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return float
     */
    public function getCurrentPrice(): float
    {
        return $this->currentPrice;
    }

}
