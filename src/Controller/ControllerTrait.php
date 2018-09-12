<?php

namespace Lean\Controller;

use DI\Container;
use League\Plates\Engine;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

trait ControllerTrait
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param Container $container
     */
    public function setContainer(Container $container): void
    {
        $this->container = $container;

        // Some "always used" services
        $this->logger = $container->get(LoggerInterface::class);
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

    /**
     * Logs a message
     *
     * @param string $msg
     * @param int $level
     */
    protected function log(string $msg, int $level = Logger::INFO){
        $this->logger->log($level, $msg);
    }
}
