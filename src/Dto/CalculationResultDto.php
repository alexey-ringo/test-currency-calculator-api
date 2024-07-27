<?php
declare(strict_types=1);

namespace App\Dto;

class CalculationResultDto
{
    public function __construct(
        private readonly CurrencyDto $currencyFrom,
        private readonly CurrencyDto $currencyTo,
        private readonly float $amount
    ) {}

    public function getCurrencyFrom(): CurrencyDto
    {
        return $this->currencyFrom;
    }

    public function getCurrencyTo(): CurrencyDto
    {
        return $this->currencyTo;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
