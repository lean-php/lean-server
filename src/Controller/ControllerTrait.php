<?php

namespace Lean\Controller;

use DI\Container;
use League\Plates\Engine;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * @param string $template
     * @param array $data
     * @return Response
     */
    protected function render(string $template, array $data = [])
    {
        $plates = $this->container->get(Engine::class);
        return new Response($plates->render($template, $data));
    }
}
