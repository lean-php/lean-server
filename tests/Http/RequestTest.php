<?php

namespace Lean\Tests\Http;

use Lean\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testIsCreatable()
    {
        $request = new Request();
        $this->assertNotNull($request);
    }
}
