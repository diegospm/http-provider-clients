<?php

declare(strict_types=1);

namespace HttpProvider\Tests\Clients;

use \HttpProvider\Interfaces\{ClientInterface, ResponseInterface};
use \HttpProvider\Clients\Guzzle;
use \HttpProvider\Responses\JsonResponse;
use \PHPUnit\Framework\TestCase;

class GuzzleTest extends TestCase
{
    private Guzzle $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = new Guzzle([]);
    }

    public function testAttachResponse(): void
    {
        $this->assertInstanceOf(ClientInterface::class, $this->client->attachResponse(new JsonResponse()));
    }

    public function testSetUrl(): void
    {
        $this->assertInstanceOf(ClientInterface::class, $this->client->setUrl('https://api.github.com/search/repositories?q=diegospm/http-provider-responses'));
    }

    public function testSetMethod(): void
    {
        $this->assertInstanceOf(ClientInterface::class, $this->client->setMethod('get'));
    }

    public function testSetParams(): void
    {
        $this->assertInstanceOf(ClientInterface::class, $this->client->setParams([]));
    }

    public function testSetBody(): void
    {
        $this->assertInstanceOf(ClientInterface::class, $this->client->setBody(null));
    }

    public function testSend(): void
    {
        $this->client->attachResponse(new JsonResponse())
        ->setUrl('https://api.github.com/search/repositories?q=diegospm/http-provider-responses')
        ->setMethod('get');

        $this->assertInstanceOf(ResponseInterface::class, $this->client->send());
    }
}
