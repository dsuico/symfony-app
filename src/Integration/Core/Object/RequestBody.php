<?php

declare(strict_types=1);

namespace App\Integration\Core\Object;

use App\Integration\Core\Enum\BodyType;

class RequestBody
{
  public function __construct(
    private mixed $payload,
    private BodyType $type = BodyType::JSON,
  ) {}

  public function getType(): BodyType
  {
    return $this->type;
  }

  public function getPayload(): mixed
  {
    return $this->payload;
  }
}