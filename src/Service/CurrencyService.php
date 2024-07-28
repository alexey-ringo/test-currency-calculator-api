<?php
declare(strict_types=1);

namespace App\Service;

use App\Dto\ExchangeRequestDto;
use App\Dto\ExchangeResponseDto;
use App\Dto\CurrencyDto;
use App\Repository\CurrencyRepository;
use Doctrine\Common\Collections\Collection;

class CurrencyService
{
    public function __construct(
        private readonly CurrencyRepository $repository,
    ) {}

    public function list(?string $code = null): Collection
    {
        $currencyCollection = $this->repository->getCollectionFromFile();

        if ($code === null) {
            return $currencyCollection;
        }

        $currencyDto = $this->repository->findCurrency($code, $currencyCollection);
        $rate = 1 / $currencyDto->getRate();

        return $this->repository->recalculateCurrencyCollection($code, $rate, $currencyCollection);
    }

    public function exchange(ExchangeRequestDto $dto): ExchangeResponseDto
    {
        $currencyCollection = $this->repository->getCollectionFromFile();
        $currencyFromDto = $this->repository->findCurrency($dto->getCurrencyFrom(), $currencyCollection);
        $currencyToDto = $this->repository->findCurrency($dto->getCurrencyTo(), $currencyCollection);
        $exchangeRate = $currencyFromDto->getRate() / $currencyToDto->getRate();

        return new ExchangeResponseDto(
            amount: $dto->getAmount() * $exchangeRate,
            currencyFrom: new CurrencyDto(
                code: $currencyFromDto->getCode(),
                name: $currencyFromDto->getName(),
                rate: $currencyFromDto->getRate()
            ),
            currencyTo: new CurrencyDto(
                code: $currencyToDto->getCode(),
                name: $currencyToDto->getName(),
                rate: $currencyToDto->getRate()
            )
        );
    }
}
