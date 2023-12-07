<?php

declare(strict_types=1);

namespace A50\Http\Middleware;

use InvalidArgumentException;
use Webmozart\Assert\Assert;

final class MiddlewaresConfig
{
    /** @var array<string, class-string[]> */
    private array $middlewares;

    /**
     * @param array<string, class-string[]> $middlewares
     */
    private function __construct(array $middlewares)
    {
        if (empty($middlewares)) {
            $this->middlewares = $middlewares;

            return;
        }

        foreach ($middlewares as $for => $middlewareClassNames) {
            foreach ($middlewareClassNames as $middlewareClassName) {
                $this->assertMiddleware($middlewareClassName);
                $this->middlewares[$for] = [$middlewareClassName];
            }
        }
    }

    /**
     * @param array<string, class-string[]> $middlewares
     */
    public static function withDefaults(array $middlewares = []): self
    {
        return new self($middlewares);
    }

    /**
     * @param class-string $middlewareClassName
     * @return $this
     */
    public function withMiddleware(string $middlewareClassName, string $for = 'common'): self
    {
        Assert::stringNotEmpty($middlewareClassName);
        Assert::stringNotEmpty($for);
        $this->assertMiddleware($middlewareClassName);

        $new = clone $this;
        $new->middlewares[$for] = [$middlewareClassName];

        return $new;
    }

    /**
     * @param class-string $middlewareClassName
     */
    private function assertMiddleware(string $middlewareClassName): void
    {
        Assert::stringNotEmpty($middlewareClassName);
        $middlewareInterface = 'Psr\Http\Server\MiddlewareInterface';
        if (!in_array($middlewareInterface, class_implements($middlewareClassName), true)) {
            throw new InvalidArgumentException(\sprintf('Class %s must implements %s', $middlewareClassName, $middlewareInterface));
        }
    }

    /**
     * @return array<string, class-string[]>
     */
    public function middlewares(): array
    {
        return $this->middlewares;
    }
}
