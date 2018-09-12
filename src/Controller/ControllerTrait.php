<?php

namespace Lean\Controller;

use DI\Container;
use League\Plates\Engine;
use Lean\Http\Response;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

trait ControllerTrait
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var LoggerInterface
     */
    protected $log;

    /**
     * @var LoggerInterface
     */
    private $userLog;

    /**
     * @param Container $container
     */
    public function setContainer(Container $container): void
    {
        $this->container = $container;

        // Set immediatly some service (always used)
        $this->log = $container->get(LoggerInterface::class);
        $this->userLog = $container->get('user.log');
    }

    public function render(string $template, array $data = [])
    {
        $plates = $this->container->get(Engine::class);
        return new Response($plates->render($template, $data));
    }

    public function getRouteParam(string $name) {
        $routeData = $this->container->get('route');
        return $routeData[$name] ?? null;
    }

    public function logUserAction(string $msg)
    {
        $this->userLog->info($msg);
    }

    protected $cache;

    public function getCache() {
        return $this->cache ??
            $this->cache = $this->container->get(CacheInterface::class);
    }
}
