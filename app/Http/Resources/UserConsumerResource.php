<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserConsumerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'crypto_currency' => $this['crypto_currency'],
            'currency' => $this['currency'],
            'high24' => $this['high24'],
            'low24' => $this['low24'],
            'current_price' => $this['current_price'],
        ];
    }
}
