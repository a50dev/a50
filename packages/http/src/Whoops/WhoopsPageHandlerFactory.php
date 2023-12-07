<?php

declare(strict_types=1);

namespace A50\Http\Whoops;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Whoops\Handler\PrettyPageHandler;

use function is_callable;

final class WhoopsPageHandlerFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): PrettyPageHandler
    {
        /** @var WhoopsConfig $config */
        $config = $container->get(WhoopsConfig::class);

        $pageHandler = new PrettyPageHandler();

        $this->injectEditor($pageHandler, $config, $container);

        return $pageHandler;
    }

    /**
     * Inject an editor into the whoops configuration.
     *
     * @see https://github.com/filp/whoops/blob/master/docs/Open%20Files%20In%20An%20Editor.md
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function injectEditor(PrettyPageHandler $handler, WhoopsConfig $config, ContainerInterface $container): void
    {
        $editor = $config->editor();

        if (is_callable($editor)) {
            $handler->setEditor($editor);

            return;
        }

        if ($editor instanceof Editor) {
            $handler->setEditor($editor->value);
        }
    }
}
