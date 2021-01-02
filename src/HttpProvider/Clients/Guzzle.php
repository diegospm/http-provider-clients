<?php

declare(strict_types=1);

namespace HttpProvider\Clients;

use HttpProvider\Interfaces\{ClientInterface, ResponseInterface};
use \GuzzleHttp\Client;
use \GuzzleHttp\Psr7\Request;

class Guzzle implements ClientInterface
{
    private Client $client;

    private ResponseInterface $response;

    private string $url;

    private string $method;

    private array $params = [];

    /**
     * @var mixed
     */
    private $body = null;

    public function __construct(array $options = [])
    {
        $this->client = new Client(array_merge(['http_errors' => false], $options));
    }

    public function attachResponse(ResponseInterface $response): ClientInterface
    {
        $this->response = $response;

        return $this;
    }

    public function setUrl(string $url): ClientInterface
    {
        $this->url = $url;

        return $this;
    }

    public function setMethod(string $method): ClientInterface
    {
        $this->method = $method;

        return $this;
    }

    public function setParams(array $params): ClientInterface
    {
        $this->params = $params;

        return $this;
    }

    public function setBody($body): ClientInterface
    {
        $this->body = $body;

        return $this;
    }

    public function send(): ResponseInterface
    {
        $request    = new Request($this->method, $this->url, $this->params, $this->body);
        $response   = $this->client->send($request);

        return $this->response->setStatusCode($response->getStatusCode())
        ->setContent($response->getBody()->getContents());
    }
}
