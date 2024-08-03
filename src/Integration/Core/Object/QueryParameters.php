<?php

namespace App\Integration\Core\Object;

use JsonSerializable;

class QueryParameters {

    protected array $queries = [];

    public function add(string $key, mixed $value): self
    {
        $this->queries[] = array(
            'key'   => $key,
            'value' => $value
        );

        return $this;
    }

    public function findByKey(string $key): mixed
    {
        $value = null;

        foreach($this->queries as $query)
            if($query['key'] === $key)
                $value = $query['value'];
    
        return $value;
    }

    public function exists(string $key): bool
    {
        $found = false;

        foreach($this->queries as $query)
            if($query['key'] === $key) {
                $found = true;
                break;
            }

        return $found;
    }

    public function addOrReplace(string $key, mixed $value): self {

        $found = false;

        foreach($this->queries as &$query) {
            if($query['key'] === $key) {
                $query['key'] = $key;
                $query['value'] = $value;
                $found = true;
                break;
            }
        }

        if(!$found)
            $this->add($key, $value);

        return $this;
    }

    public function size(): int
    {
        return count($this->queries);
    }

    public function getParameters(): array
    {
        return $this->queries;
    }

    public function toString($separator = '&', $equals = '='): string
    {
        $queries = [];

        foreach($this->queries as $query)
            $queries[] = urlencode($query['key'] ?? $query['key']) . $equals . urlencode($query['value']);

        return implode($separator, $queries);
    }

    public function toArray()
    {
        $queries = [];

        foreach($this->queries as $query)
            $queries[$query['key']] =
                is_object($query['value']) && $query['value'] instanceof JsonSerializable ?
                    json_encode($query['value']) :
                    $query['value'];

        return $queries;
    }
}