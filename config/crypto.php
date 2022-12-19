<?php

return [
    'provider' => env('CRYPTO_PROVIDER', 'CoinGecko'),

    /**
     * Supported Currencies
     */
    'vs_currencies' => ['usd', 'eur', 'jpy'],

    /**
     * Default Currency
     */
    'default_vs_currency' => 'usd',

    /**
     * Supported Crypto currencies
     */
    'currencies' => ['bitcoin', 'litecoin', 'ethereum'],

    /**
     * Crypto Service Provider
     */
    'CoinGecko' => [
        'endpoint' => 'https://api.coingecko.com/api/v3',
    ],
];
