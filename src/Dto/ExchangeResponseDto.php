<?php
declare(strict_types=1);

namespace App\Dto;

class ExchangeResponseDto
{
    public function __construct(
        private readonly float $amount,
        private readonly CurrencyDto $currencyFrom,
        private readonly CurrencyDto $currencyTo
    ) {}

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrencyFrom(): CurrencyDto
    {
        return $this->currencyFrom;
    }

    public function getCurrencyTo(): CurrencyDto
    {
        return $this->currencyTo;
    }
}
