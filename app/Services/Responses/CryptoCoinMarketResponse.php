<?php

namespace App\Services\Responses;

class CryptoCoinMarketResponse extends AbstractCryptoResponse
{
    protected string $cryptoCurrency;

    protected string $currency;

    protected float $high24;

    protected float $low24;

    public function __construct(string $cryptoCurrency, string $currency, array $response)
    {
        $this->cryptoCurrency = $cryptoCurrency;
        $this->currency = $currency;
        $this->high24 = $response['high_24h'];
        $this->low24 = $response['low_24h'];
    }

    /**
     * @return float
     */
    public function getHigh24(): float
    {
        return $this->high24;
    }

    /**
     * @return float
     */
    public function getLow24(): float
    {
        return $this->low24;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getCryptoCurrency(): string
    {
        return $this->cryptoCurrency;
    }
}
