<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

class UserConsumerControllerTest extends TestCase
{
    public function testDefaultCurrencyRequestWithA200Response()
    {
        $response = $this->get('api/user/consumer')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'crypto_currency',
                        'currency',
                        'high24',
                        'low24',
                        'current_price'
                    ]
                ]
            ]);

        foreach (config('crypto.currencies') as $i => $supportedCurrency) {
            $response->assertJsonPath('data.' . $i . '.crypto_currency', $supportedCurrency);
            $response->assertJsonPath('data.' . $i . '.currency', config('crypto.default_vs_currency'));
            $response->assertJsonPath('data.' . $i . '.high24', fn ($item) => $item > 0);
            $response->assertJsonPath('data.' . $i . '.low24', fn ($item) => $item > 0);
            $response->assertJsonPath('data.' . $i . '.current_price', fn ($item) => $item > 0);
        }
    }

    public function testNonDefaultCurrencyRequestWithA200Response() {
        $currency = 'eur';

        $response = $this->get('api/user/consumer?currency=' . $currency, [
            'Accept' => 'application/json'
        ])->assertStatus(200)
            ->assertJsonStructure([
            'data' => [
                '*' => [
                    'crypto_currency',
                    'currency',
                    'high24',
                    'low24',
                    'current_price'
                ]
            ]
        ]);

        foreach (config('crypto.currencies') as $i => $supportedCurrency) {
            $response->assertJsonPath('data.' . $i . '.crypto_currency', $supportedCurrency);
            $response->assertJsonPath('data.' . $i . '.currency', $currency);
            $response->assertJsonPath('data.' . $i . '.high24', fn ($item) => $item > 0);
            $response->assertJsonPath('data.' . $i . '.low24', fn ($item) => $item > 0);
            $response->assertJsonPath('data.' . $i . '.current_price', fn ($item) => $item > 0);
        }
    }

    public function testInvalidCurrencyRequestWithA422Response() {
        $currency = 'abc';

        $response = $this->get('api/user/consumer?currency=' . $currency, [
                'Accept' => 'application/json'
            ]);
        $response->assertStatus(422);
    }

    public function testCryptoProviderIsLostWithA500Response() {
        config(['crypto.CoinGecko.endpoint' => '127.0.0.1']);
        $response = $this->get('api/user/consumer', [
            'Accept' => 'application/json'
        ]);
        $response->assertStatus(500)
        ->assertJson(['message' => 'Something went wrong.']);
    }

}
