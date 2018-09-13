<?php
/**
 * Created by PhpStorm.
 * User: itnrw
 * Date: 13.09.18
 * Time: 10:11
 */

namespace Lean;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CachingKernel
{
    protected $kernel;

    protected $cache;

    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
        $this->cache = $kernel->getContainer()->get('output.cache');
    }

    public function handle(Request $request) {

        $cacheKey = str_replace('/', '_', $request->getRequestUri());

        // Response in Cache?
        if ($this->cache->has($cacheKey)) {
            $response = $this->cache->get($cacheKey);
            $response->setStatusCode(304);
            return $response;
        }

            /** @var Response $response */
        $response = $this->kernel->handle($request);

        // Store Response in cache
        if ($response->isCacheable()) {
            $this->cache->set($cacheKey, $response, $response->getTtl());
        }

        return $response;
    }
}