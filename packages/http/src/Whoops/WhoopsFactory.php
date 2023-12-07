<?php

declare(strict_types=1);

namespace A50\Http\Whoops;

use Psr\Container\ContainerInterface;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Run as Whoops;
use Whoops\Util\Misc as WhoopsUtil;

final class WhoopsFactory
{
    /**
     * Create and return an instance of the Whoops runner.
     */
    public function __invoke(ContainerInterface $container): Whoops
    {
        /** @var WhoopsConfig $config */
        $config = $container->get(WhoopsConfig::class);

        $whoops = new Whoops();
        $whoops->allowQuit(false);

        /** @var WhoopsPageHandler $handler */
        $handler = $container->get(WhoopsPageHandler::class);
        $whoops->pushHandler($handler);
        $this->registerJsonHandler($whoops, $config);
        $whoops->register();

        return $whoops;
    }

    /**
     * If configuration indicates a JsonResponseHandler, configure and register it.
     */
    private function registerJsonHandler(Whoops $whoops, WhoopsConfig $config): void
    {
        if (!$config->jsonExceptionsDisplay()) {
            return;
        }

        $handler = new JsonResponseHandler();

        if ($config->jsonExceptionsShowTrace()) {
            $handler->addTraceToOutput(true);
        }

        if ($config->jsonExceptionsAjaxOnly()) {
            // Don't push handler on stack unless we are in a XHR request.
            if (! WhoopsUtil::isAjaxRequest()) {
                return;
            }
        }

        $whoops->pushHandler($handler);
    }
}
