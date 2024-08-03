<?php

namespace App\Integration\Core\Contracts\Http;

use Exception;
use GuzzleHttp\Psr7\Response;

interface Requestable
{
  public function prepare(): RequestInterface;
  public function handleResponse(Response $response): ResponseInterface;
  public function getException(string $error): Exception;
}