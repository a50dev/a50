<?php

declare(strict_types=1);

namespace A50\Http\Whoops;

use Mezzio\Middleware\WhoopsErrorResponseGenerator;
use Psr\Container\ContainerInterface;
use Whoops\RunInterface;

final class WhoopsErrorResponseGeneratorFactory
{
    public function __invoke(ContainerInterface $container): WhoopsErrorResponseGenerator
    {
        /** @var RunInterface $whoops */
        $whoops = $container->get(RunInterface::class);

        return new WhoopsErrorResponseGenerator(
            $whoops
        );
    }
}
