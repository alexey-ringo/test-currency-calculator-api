<?php
declare(strict_types=1);

namespace App\Repository;

use App\Dto\CurrencyDto;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;

class CurrencyRepository
{
    public function saveToFile(array $currencyRates): void
    {
        $jsonContent = json_encode($currencyRates, JSON_THROW_ON_ERROR);
        file_put_contents(__DIR__ . '/../../var/currency_rates.json', $jsonContent);
    }

    public function getCollectionFromFile(): Collection
    {
        $jsonContent = file_get_contents(__DIR__ . '/../../var/currency_rates.json');
        $currencies  =  json_decode($jsonContent, true);

        $collection = new ArrayCollection();
        foreach ($currencies as $currencyItem) {
            $collection->add(
                new CurrencyDto(
                    code: $currencyItem['code'],
                    name: $currencyItem['name'],
                    rate: $currencyItem['rate']
                )
            );
        }

        return $collection;
    }

    /**
     * @throws Exception
     */
    public function findCurrency(string $code, Collection $currencyCollection): CurrencyDto
    {
        $filteredCollection = $currencyCollection->filter(static function (
            CurrencyDto $dto
        ) use ($code) {
            return $dto->getCode() === $code;
        });

        $currencyDto = $filteredCollection->first();
        if (!$currencyDto instanceof CurrencyDto) {
            throw new Exception('Not found currency code: ' . $code, 404);
        }

        return $currencyDto;
    }

    public function recalculateCurrencyCollection(string $code, float $rate, Collection $currencyCollection): Collection
    {
        return $currencyCollection->map(static function (
            CurrencyDto $dto
        ) use ($code, $rate) {
            return new CurrencyDto(
                code: $dto->getCode(),
                name: $dto->getName(),
                rate: $dto->getCode() === $code ? 1.0 : $dto->getRate() * $rate
            );
        });
    }
}
