<?php

namespace Lean;

use DI\Container;
use DI\ContainerBuilder;
use League\Plates\Engine;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Kernel
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * Kernel constructor.
     */
    public function __construct()
    {
        $this->container = $this->configureContainer();
    }

    /**
     * The main Request - Response - Lifecyle
     *
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request) : Response
    {
        return new Response();
    }

    /**
     * Returns the template folder for plates engine
     *
     * @return null|string
     */
    public function getTemplateFolder() : string    {
        return $this->getRootFolder() . '/templates';
    }

    /**
     * Returns the config folder routing and services
     *
     * @return null|string
     */
    public function getConfigFolder() : string    {
        return $this->getRootFolder() . '/config';
    }

    /**
     * Returns the project folder for plates engine
     *
     * @return null|string
     */
    public function getRootFolder() : ?string    {
        return null;
    }

    /**
     * Configures the DI Container
     *
     * @return Container
     */
    private function configureContainer() {
        $containerBuilder = new ContainerBuilder();

        // Lean Definitions
        $containerBuilder->addDefinitions([
            // Plates Template Engine
            Engine::class => \DI\create()->constructor($this->getTemplateFolder(), 'phtml'),
            // Default Logger
            LoggerInterface::class => \DI\create(Logger::class)->constructor('kernel')
        ]);

        // App Definitions
        $containerBuilder->addDefinitions($this->getConfigFolder() . '/services.php');

        return $containerBuilder->build();
    }
}