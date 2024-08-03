<?php

namespace App\Integration\Core\Abstracts;

use App\Integration\Core\Contracts\Http\HttpInterface;
use App\Integration\Core\Contracts\Http\Requestable;
use App\Integration\Core\Contracts\Http\RequestInterface;
use App\Integration\Core\Contracts\Http\ResponseInterface;
use App\Integration\Core\Enum\RequestMethod;
use App\Integration\Core\Object\Error;
use App\Integration\Core\Object\Headers;
use GuzzleHttp\Client;

abstract class Http implements HttpInterface
{
  private Client $client;

  public function __construct()
  {
      $this->client = new Client;
  }
  abstract protected function getHeaders(): Headers;
  abstract protected function getBaseUrl(): string;
  abstract protected function handleRequestException(\Exception $e): Error;

  public function send(Requestable $requestable): ResponseInterface
  {
    $request = $requestable->prepare();

    try {
      switch($request->getMethod()->name) {
        case RequestMethod::GET->name:
          $response = $this->client->request(
              $request->getMethod()->name,
              $this->buildFullPath($request),
              [
                  'headers' => $this->buildHeaders($request),
                  'query' => $request->getQueryParameters()?->toArray()
              ]
          );
          return $requestable->handleResponse($response);
      }
    } catch (\Exception $e) {
      $error = $this->handleRequestException($e);
      throw $requestable->getException(json_encode($error));
    }
    
    throw $requestable->getException('unhandled request');
  }

  private function buildHeaders(RequestInterface $request): array
  {
    $headers = $this->getHeaders()->build();

    if ($request->getHeaders())
      $headers = array_merge($headers, $request->getHeaders()->build());

    return $headers;
  }

  private function buildFullPath(RequestInterface $request): string
  {
    return $request->getBaseUrl() ? 
      $request->getBaseUrl() . $request->getResourceUrl() : 
      $this->getBaseUrl() . $request->getResourceUrl();
  }
}