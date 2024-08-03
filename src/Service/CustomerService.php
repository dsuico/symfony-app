<?php

namespace App\Service;

use App\Repository\CustomerRepositoryInterface;
use Exception;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class CustomerService implements CustomerServiceInterface {
    public function __construct(
        private CustomerRepositoryInterface $customerRepository
    ) {}

    public function getAll(): iterable {
      $data = $this->customerRepository->findAll();
      $result = [];
      /** @var \App\Entity\Customer */
      foreach($data as $customer) {
        $result[] = [
          'fullName' => $customer->getFullName(),
          'email' => $customer->getEmail(),
          'country' => $customer->getCountry()
        ];
      }
      return $result;
    }

    public function getCustomerDetail(int $id): array
    {
      /** @var \App\Entity\Customer */
      $customer = $this->customerRepository->findOneBy(['id' => $id]);

      if(!$customer)
        throw new BadRequestException('customer not found');

      return [
        'fullName' => $customer->getFullName(),
        'email' => $customer->getEmail(),
        'username' => $customer->getUsername(),
        'gender' => $customer->getGender(),
        'country' => $customer->getCountry(),
        'city' => $customer->getCity(),
        'phone' => $customer->getPhone(),
      ];
    }
}