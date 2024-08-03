<?php

namespace App\Integration\RandomUser\Requests;

use App\Integration\Core\Contracts\Http\Requestable;
use App\Integration\Core\Contracts\Http\RequestInterface;
use App\Integration\Core\Contracts\Http\ResponseInterface;
use App\Integration\Core\Enum\RequestMethod;
use App\Integration\Core\Object\QueryParameters;
use App\Integration\Core\Object\Request;
use App\Integration\Core\Object\Response;
use Exception;
use GuzzleHttp\Psr7\Response as Psr7Response;

class GetCustomersRequest implements Requestable {

  public function __construct(
    private QueryParameters $query
  ) {}

  public function prepare(): RequestInterface
  {
    return new Request(RequestMethod::GET, '', null, $this->query);
  }

  public function handleResponse(Psr7Response $response): ResponseInterface
  {
    $result = json_decode($response->getBody()->getContents(), true);

    return new Response($result);
  }

  public function getException(string $error): Exception
  {
    return new Exception($error);
  }
}