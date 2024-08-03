<?php

namespace App\Service;

use App\Integration\Core\Contracts\Http\ResponseInterface;
use App\Integration\Core\Object\QueryParameters;

interface DataImporterService {
  public function getCustomers(QueryParameters $query): ResponseInterface;
}