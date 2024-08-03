<?php

declare(strict_types=1);

namespace App\Integration\Core\Object;

use JsonSerializable;

final class Error implements JsonSerializable{

    public function __construct(
        private array|string $value,
        private string $key = '',
        private int $code = 500 
    ) {}

    public function jsonSerialize(): mixed
    {
        $error = array($this->value);

        if($this->key)
            $error[$this->key] = $this->value;

        return $error;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue(): array|string
    {
        return $this->value;
    }

    public function toString()
    {
        return json_encode($this->value);
    }
}