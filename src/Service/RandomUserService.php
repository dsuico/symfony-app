<?php

namespace App\Service;

use App\Integration\Core\Contracts\Http\HttpInterface;
use App\Integration\Core\Contracts\Http\ResponseInterface;
use App\Integration\Core\Object\QueryParameters;
use App\Integration\RandomUser\Requests\GetCustomersRequest;

class RandomUserService implements DataImporterService {

  public function __construct(
    private HttpInterface $http
  ) {
    $this->http->init();
  }

  public function getCustomers(QueryParameters $query): ResponseInterface {
    return $this->http->send(new GetCustomersRequest($query));
  }
}