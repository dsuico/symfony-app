<?php

declare(strict_types=1);

namespace App\Integration\Core\Object;

use App\Integration\Core\Contracts\Http\RequestInterface;
use App\Integration\Core\Enum\RequestMethod;

class Request implements RequestInterface
{
  public function __construct(
    private RequestMethod $method,
    private string $resourceUrl,
    private ?RequestBody $body = null,
    private ?QueryParameters $queryParameters = null,
    private ?Headers $headers = null,
    private ?string $baseUrl = null,
  ) {}

    public function getMethod(): RequestMethod
    {
      return $this->method;
    }

    public function getResourceUrl(): string
    {
      return $this->resourceUrl;
    }

    public function getQueryParameters(): ?QueryParameters
    {
      return $this->queryParameters;
    }

    public function getHeaders(): ?Headers
    {
      return $this->headers;
    }

    public function getBaseUrl(): ?string
    {
      return $this->baseUrl;
    }

    public function getBody(): ?RequestBody
    {
      return $this->body;
    }
}