<?php

declare(strict_types=1);

namespace A50\CommandBus;

final class CommandBusConfig
{
    /**
     * @var array<class-string, class-string>
     */
    private array $handlersMap;
    /**
     * @var array<class-string>
     */
    private array $middlewares;

    private function __construct(array $handlersMap, array $middlewares)
    {
        $this->handlersMap = $handlersMap;
        $this->middlewares = $middlewares;
    }

    /**
     * @param array<class-string, class-string> $handlersMap
     * @param class-string[] $middlewares
     */
    public static function withDefaults(
        array $handlersMap = [],
        array $middlewares = [],
    ): self {
        return new self($handlersMap, $middlewares);
    }

    /**
     * @param class-string $commandClassName
     * @param class-string $handlerClassName
     * @return $this
     */
    public function withHandlerFor(string $commandClassName, string $handlerClassName): self
    {
        $new = clone $this;
        $new->handlersMap[$commandClassName] = $handlerClassName;

        return $new;
    }

    /**
     * @param array<class-string, class-string> $handlersMap
     * @return $this
     */
    public function withHandlersFor(array $handlersMap): self
    {
        $new = clone $this;

        foreach ($handlersMap as $commandClassName => $handlerClassName) {
            $new = $new->withHandlerFor($commandClassName, $handlerClassName);
        }

        return $new;
    }

    /**
     * @return array<class-string, class-string>
     */
    public function handlersMap(): array
    {
        return $this->handlersMap;
    }

    /**
     * @param class-string $middlewareClassName
     * @return $this
     */
    public function withMiddleware(string $middlewareClassName): self
    {
        $new = clone $this;
        $new->middlewares[] = $middlewareClassName;

        return $new;
    }

    /**
     * @param class-string[] $middlewares
     * @return $this
     */
    public function withMiddlewares(array $middlewares): self
    {
        $new = clone $this;
        foreach ($middlewares as $middlewareClassName) {
            $new = $new->withMiddleware($middlewareClassName);
        }

        return $new;
    }

    /**
     * @return class-string[]
     */
    public function middlewares(): array
    {
        return $this->middlewares;
    }
}
