<?php

namespace Lean;

use Lean\Http\Request;
use Lean\Http\Response;

class Kernel
{
    public function handle(Request $request)
    {
        return new Response();
    }
}