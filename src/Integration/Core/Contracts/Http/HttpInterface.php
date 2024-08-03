<?php

namespace App\Integration\Core\Contracts\Http;

interface HttpInterface
{
  public function init(): void;
  public function send(Requestable $request): ResponseInterface;
}