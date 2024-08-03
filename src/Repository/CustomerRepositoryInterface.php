<?php

namespace App\Repository;

use App\Entity\Customer;

interface CustomerRepositoryInterface
{
  public function save(Customer $customer): void;
  public function findOneByEmail(string $email): ?Customer;
  public function findAll(): array;
  public function findOneBy(array $criteria, array $orderBy = null);
}