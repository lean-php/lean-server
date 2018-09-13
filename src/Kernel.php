<?php

namespace Lean;

use DI\Container;
use DI\ContainerBuilder;
use FastRoute\Dispatcher;
use League\Plates\Engine;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use ReflectionObject;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class Kernel
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var Dispatcher
     */
    protected $router;

    /**
     * @var bool
     */
    protected $debugMode;

    /**
     * @var callable[]
     */
    protected $asyncHandlers;

    /**
     * Kernel constructor.
     */
    public function __construct(bool $debug = true)
    {
        $this->debugMode = $debug;
        $this->asyncHandlers = [];
        $this->container = $this->configureContainer();
        $this->router = $this->configureRouter();

        $this->container->set('app.kernel', $this); // Value Pattern
    }

    public function addAsyncTask(callable $handler)
    {
        $this->asyncHandlers[] = $handler;
    }

    public function terminate()
    {
        foreach ($this->asyncHandlers as $h) {
            $h();
        }
    }

    /**
     * The main Request - Response - Lifecyle
     *
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request) : Response
    {
        //session_start();

        // Security: Authorization Stufe 1 (darf Rolle diese Route benutzen?)
        $route = $this->router->dispatch($request->getMethod(), $request->getPathInfo());





        switch ($route[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                return new Response('<body><pre>Lost in Space</pre></body>', 404);
                break;

            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $route[1];
                return new Response('<body><pre>Ups, what do you want?</pre></body>', 405);
                break;

            case \FastRoute\Dispatcher::FOUND:

                $_ctrl = $route[1]['_ctrl'] ?? null;
                $_action = $route[1]['_action'] ?? null;
                $_allowedRoles = $route[1]['_roles'] ?? null;

                $ctrl = $this->container->get($route[1]['_ctrl']);

                if(method_exists($ctrl, 'setContainer')) {
                    call_user_func([$ctrl, 'setContainer'], $this->container );
                }

                $action = $route[1][1];

                // Resolving Controller Arguments
                $reflectionParams = (new ReflectionObject($ctrl))->getMethod($action)->getParameters();
                $routeParams = $route[2];
                $args = [];
                foreach ($reflectionParams as $param) {
                    if ($param->getType()->getName() === Request::class) {
                        $args[] = $request;
                    } elseif (array_key_exists($param->name, $routeParams)) {
                        $args[] = $routeParams[$param->name];
                    } elseif (false) {
                        // Lookup in Container
                    } elseif (false) {
                        // Lookup in Session
                    } elseif (isset($_GET[$param->name])) {
                        // Lookup in Request
                        $args[] = $_GET[$param->name];
                    }
                }

                return call_user_func_array([$ctrl, $action], $args);
                break;
        }
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
        return dirname(__DIR__) . '/app';
    }

    /**
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * Configures the DI Container
     *
     * @return Container
     */
    private function configureContainer() : Container {
        $containerBuilder = new ContainerBuilder();

        // Lean Definitions
        $containerBuilder->addDefinitions([
            // Plates Template Engine
            Engine::class => \DI\create()->constructor($this->getTemplateFolder(), 'phtml'),
            // Default Logger
            LoggerInterface::class => \DI\create(Logger::class)->constructor('kernel'),
            // Output Cache
            'output.cache' => \DI\create(FilesystemCache::class)
        ]);

        // App Definitions
        $containerBuilder->addDefinitions($this->getConfigFolder() . '/services.php');

        return $containerBuilder->build();
    }

    private function configureRouter() : Dispatcher
    {
        $routeCollector = require $this->getConfigFolder() . '/routes.php';
        return \FastRoute\cachedDispatcher($routeCollector, [
            'cacheFile' => $this->getRootFolder() . '/var/cache/route.cache',
            'cacheDisabled' => $this->debugMode,     /* optional, enabled by default */
        ]);
    }
}