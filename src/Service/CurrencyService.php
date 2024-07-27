<?php
declare(strict_types=1);

namespace App\Service;

use App\Dto\CalculationResultDto;
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

    public function calculate(): CalculationResultDto
    {
        return new CalculationResultDto(
            currencyFrom: new CurrencyDto(
                code: 'USD',name: 'US Dollar',rate: 1.2222
            ),
            currencyTo: new CurrencyDto(
                code: 'EUR',name: 'Euro',rate: 1.0
            ),
            amount: 1.234,
        );

    }
}
