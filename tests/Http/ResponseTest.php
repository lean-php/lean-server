<?php

namespace Lean\Tests\Http;

use Lean\Http\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testIsCreatableWithDefaultConstructorAndHasStatusCode200()
    {
        $response = new Response();

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testIsCreatableWithBodyAndHasStatusCode200()
    {
        $body = '<h2>Yep</h2>';
        $response = new Response($body);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals( $body, $response->getBody());
    }

    public function testCanSetStatusCodeAndBodyViaConstructor()
    {
        $body = '<h2>Nope!</h2>';
        $response = new Response($body, 404);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals( $body, $response->getBody());
    }

    public function testCanSetHeadersViaConstructor()
    {
        $body = '[]';
        $response = new Response($body, 200, ['Content-Type' => 'application/json']);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals( $body, $response->getBody());
        $this->assertArrayHasKey('Content-Type', $response->getHeaders());
    }

    public function testReasonPhrases() {
        $response = new Response();
        $this->assertEquals('OK', $response->getReasonPhrase());

        $response = new Response('', 201);
        $this->assertEquals('Created', $response->getReasonPhrase());

        $response = new Response('', 404);
        $this->assertEquals('Not Found', $response->getReasonPhrase());
    }
}
