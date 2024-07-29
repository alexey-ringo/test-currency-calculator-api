<?php
declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class ExchangeRequestDto
{
    #[Assert\NotBlank]
    #[Assert\Type('numeric')]
    private string $amount;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(min: 3, max: 5)]
    private string $currencyFrom;


    #[Assert\Type('string')]
    #[Assert\Length(min: 3, max: 5)]
    private string $currencyTo;

    public function __construct(
        mixed $amount,
        mixed $currencyFrom,
        mixed $currencyTo
    ) {
        $this->amount = $amount;
        $this->currencyFrom = $currencyFrom;
        $this->currencyTo = $currencyTo;
    }

    public function getAmount(): mixed
    {
        return $this->amount;
    }

    public function getCurrencyFrom(): mixed
    {
        return $this->currencyFrom;
    }

    public function getCurrencyTo(): mixed
    {
        return $this->currencyTo;
    }
}
