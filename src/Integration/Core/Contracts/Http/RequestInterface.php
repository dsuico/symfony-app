<?php

namespace App\Integration\Core\Contracts\Http;

use App\Integration\Core\Enum\RequestMethod;
use App\Integration\Core\Object\Headers;
use App\Integration\Core\Object\QueryParameters;
use App\Integration\Core\Object\RequestBody;

interface RequestInterface {
  public function getBaseUrl(): ?string;
  public function getHeaders(): ?Headers;
  public function getQueryParameters(): ?QueryParameters;
  public function getResourceUrl(): string;
  public function getMethod(): RequestMethod;
  public function getBody(): ?RequestBody;
}