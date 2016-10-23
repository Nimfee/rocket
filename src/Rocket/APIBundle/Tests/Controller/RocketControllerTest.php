<?php

namespace Rocket\APIBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RocketControllerTest extends WebTestCase
{
    private $client;

    private $container;

    private $baseUrl;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->client = static::createClient();

        $this->container = static::$kernel->getContainer();

        $this->baseUrl = $this->container->getParameter('api.path');

    }

    public function testGetByCode()
    {
        $code = 'EGLL';
        $this->client->request(
            'GET',
            $this->baseUrl . 'rocket/getByCode/' . $code
        );
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 200);

    }

    public function testIndex()
    {
        $this->client->request(
            'GET',
            $this->baseUrl . 'rocket'
        );
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 200);

    }
}