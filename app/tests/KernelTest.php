<?php

namespace App\Tests;

use App\Kernel;
use PHPUnit\Framework\TestCase;

class KernelTest extends TestCase
{
    public function testIsALeanKernel()
    {
        $kernel = new Kernel();
        $this->assertInstanceOf(\Lean\Kernel::class, $kernel);
    }
}
