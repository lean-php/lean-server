<?php

namespace Lean\Controller;

use DI\Container;
use League\Plates\Engine;
use Lean\Http\Response;

trait ControllerTrait
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @param Container $container
     */
    public function setContainer(Container $container): void
    {
        $this->container = $container;
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
}
