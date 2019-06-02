<?php

namespace ECorp;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;

abstract class ECorpRestApiTest extends TestCase
{
    const NGINX_DOCKER_IMAGE = 'ecorp-nginx';
    const API_URL = 'http://'.self::NGINX_DOCKER_IMAGE;

    /**
     * @var ClientInterface
     */
    protected $httpClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->httpClient = new Client(['http_errors' => false]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->httpClient = null;
    }
}
