<?php

namespace App\Integration\Core\Contracts\Http;

interface ResponseInterface {
  public function getResult(): mixed;
  public function getObject(): ?object;
  public function getHeaders(): array;
}