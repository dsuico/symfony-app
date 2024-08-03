<?php

namespace App\Integration\RandomUser;

use App\Integration\Core\Abstracts\Http;
use App\Integration\Core\Object\Headers;
use App\Integration\Core\Object\Error;
use Exception;
use GuzzleHttp\Exception\ClientException;

class RandomUserHttp extends Http
{
    private Headers $headers;

    public function __construct(
        private string $baseUrl
    ) {
        $this->headers = new Headers;
        parent::__construct();
    }

    public function init(): void
    {
        if (!$this->baseUrl)
            throw new Exception('Cannot initialize. No base url was set.');

        $this->headers->add('Accept', 'application/json');
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getHeaders(): Headers
    {
        return $this->headers;
    }


    /**
     * @param \GuzzleHttp\Exception\ClientException $e
     */
    public function handleRequestException(\Exception $e): Error
    {
        switch (get_class($e)) {
            case ClientException::class:
                $response = $e->getResponse();

                $error = json_decode($response->getBody()->getContents(), true);

                if (!$error)
                    $error = $e->getMessage();

                return new Error($error, '', $e->getCode());
                break;
            default:
                $error = $e->getMessage();
        }

        return new Error($error);
    }
}
