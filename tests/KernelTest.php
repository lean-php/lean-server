<?php

namespace Lean\Tests;

use Lean\Kernel;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class KernelTest extends TestCase
{
    public function testIsCreatable()
    {
        $kernel = new Kernel();
        $this->assertNotNull($kernel);
    }

    public function testCanHandleARequest()
    {
        $mockRequest = $this->createMock(Request::class);

        $kernel = new Kernel();
        $response = $kernel->handle($mockRequest);

        $this->assertInstanceOf(Response::class, $response);
    }

    public function testHasGetTemplateFolderMethod()
    {
        $kernel = new Kernel();
        $folder = $kernel->getTemplateFolder();

        $this->assertStringEndsWith('templates', $folder);
    }
}
