<?php

namespace App\Controller;

use App\Dto\ExchangeRequestDto;
use App\Service\CurrencyService;
use App\Validator\Validator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route(path: '/api/v1/currency', name: 'currencies', methods: ['GET'])]
    public function list(Request $request, CurrencyService $service): Response
    {
        $quotes = $request->query->get('quotes');
        return $this->json($service->list($quotes));
    }

    #[Route(path: '/api/v1/exchange', name: 'exchange', methods: ['GET'])]
    public function calc(Request $request, CurrencyService $service, Validator $validator): Response
    {
        $dto = new ExchangeRequestDto(
            amount: $request->query->get('amount'),
            currencyFrom: $request->query->get('currency_from'),
            currencyTo: $request->query->get('currency_to') ?? 'USD'
        );
        $validator->validate($dto);

        return $this->json($service->exchange($dto));
    }
}
