<?php

declare(strict_types=1);

namespace App\Integration\Core\Object;

use App\Integration\Core\Contracts\Http\ResponseInterface;

class Response implements ResponseInterface
{
  public function __construct(
    private mixed $result = null,
    private ?array $headers = null,
    private ?object $object = null,
  ) {}

  public function getResult(): mixed
  {
    return $this->result;
  }

  public function getHeaders(): array
  {
    return $this->headers;
  }

  public function getObject(): ?object
  {
    return $this->object;
  }
}