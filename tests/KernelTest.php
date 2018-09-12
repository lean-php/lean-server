<?php

namespace Lean\Tests;

use Lean\Kernel;
use PHPUnit\Framework\TestCase;

class KernelTest extends TestCase
{
    public function testIsCreatable()
    {
        $kernel = new Kernel();
        $this->assertNotNull($kernel);
    }
}
