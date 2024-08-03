<?php

namespace App\Service;

interface CustomerServiceInterface {
  public function getAll(): iterable;
  public function getCustomerDetail(int $id): array;
}