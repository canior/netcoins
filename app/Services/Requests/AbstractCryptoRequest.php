<?php

namespace App\Services\Requests;

abstract class AbstractCryptoRequest
{
    public abstract function toArray(): array;
}
