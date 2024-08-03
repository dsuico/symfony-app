<?php

namespace App\Controller;

use App\Service\CustomerServiceInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class CustomerController extends AbstractController
{
    public function __construct(
        private CustomerServiceInterface $customerService
    ) {}

    #[Route(
        path: '/api/customers',
        name: 'api_get_customers',
        methods: ['GET'],
        format: 'json'
    )]
    public function index(): JsonResponse
    {   
        try {
            $result = $this->customerService->getAll();
            return $this->json($result);
        } catch (Exception $e) {
            return new JsonResponse($e->getMessage(), 422);
        }
    }

    #[Route('/api/customers/{customerId}', name: 'app_customer')]
    public function show(int $customerId): JsonResponse
    {   
        try {
            $result = $this->customerService->getCustomerDetail($customerId);
            return $this->json($result);
        } catch (Exception $e) {
            return new JsonResponse($e->getMessage(), 422);
        }
    }
}
