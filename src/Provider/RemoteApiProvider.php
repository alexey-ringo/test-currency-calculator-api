<?php
declare(strict_types=1);

namespace App\Provider;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class RemoteApiProvider
{
    const COINPAPRICA_URL = 'https://api.coinpaprika.com/v1/exchanges/coinbase/markets?quotes=USD';
    const FLOATRATES_URL = 'https://www.floatrates.com/daily/usd.json';


    public function __construct(
        private readonly HttpClientInterface $client,
    ) {}

    public function getRemoteApisContent(): array
    {
        $coinpaprikaContent = $this->getCoinpaprikaApi();
        $floatratesContent = $this->getFloatratesApi();

        return array_merge($floatratesContent, $coinpaprikaContent);
    }

    public function getCoinpaprikaApi(): array
    {
        $response = $this->client->request(
            'GET',
            self::COINPAPRICA_URL
        );
//        $statusCode = $response->getStatusCode();
//        // $statusCode = 200
        $content = $response->toArray();

        $result = [];

        foreach ($content as $contentItem) {
            $item = [];
            $originalName = $contentItem['pair'];
            $item['code'] = substr($originalName, 0, strpos($originalName, "/"));
            $item['name'] = $contentItem['base_currency_name'];
            $item['rate'] = (float)$contentItem['quotes']['USD']['price'];
            $result[] = $item;
        }

        return $result;
    }

    public function getFloatratesApi(): array
    {
        $response = $this->client->request(
            'GET',
            self::FLOATRATES_URL
        );
//        $statusCode = $response->getStatusCode();
//        // $statusCode = 200
        $content = $response->toArray();

        $result = [];

        foreach ($content as $contentItem) {
            $item = [];
            $item['code'] = $contentItem['code'];
            $item['name'] = $contentItem['name'];
            $item['rate'] = (float) $contentItem['rate'];
            $result[] = $item;
        }

        $usd = [];
        $usd['code'] = 'USD';
        $usd['name'] = 'United States Dollar';
        $usd['rate'] = 1.0;
        $result[] = $usd;

        return $result;
    }

}
