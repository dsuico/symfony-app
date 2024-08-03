<?php

namespace App\Integration\Core\Object;

class Headers {

    /**
     * @var array
     */
    private $headers;

    public function add(string $key, string $value): void
    {
        $this->headers[] = array(
            'key'   => $key,
            'value' => $value
        );
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    public function isEmpty(): bool {
        return count($this->headers) < 1;
    }

    public function build(): array
    {
        $headers = [];
        
        if($this->headers)
            foreach($this->headers as $header)
                $headers[$header['key']] = $header['value'];

        return $headers;
    }
}