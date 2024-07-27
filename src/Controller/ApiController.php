<?php

namespace App\Controller;

use App\Repository\CurrencyRepository;
use App\Service\CurrencyService;
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

    #[Route(path: '/api/v1/calculate', name: 'calculate', methods: ['GET'])]
    public function calc(Request $request, CurrencyService $service): Response
    {
        $quotes = $request->query->get('quotes');
        return $this->json($service->calculate());
    }
}
