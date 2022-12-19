<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserConsumerRequest;
use App\Services\UserConsumerService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserConsumerController extends Controller
{
    private UserConsumerService $userConsumerService;

    public function __construct(UserConsumerService $userConsumerService) {
        $this->userConsumerService = $userConsumerService;
    }

    public function __invoke(UserConsumerRequest $request): AnonymousResourceCollection
    {
        $currency = $request->input('currency', config('crypto.default_vs_currency'));

        return $this->userConsumerService->consume($currency);
    }
}
