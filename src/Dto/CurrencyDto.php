<?php
declare(strict_types=1);

namespace App\Dto;

class CurrencyDto
{
    public function __construct(
        private readonly string $code,
        private readonly string $name,
        private readonly float $rate
    ) {}

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRate(): float
    {
        return $this->rate;
    }
}
