<?php

declare(strict_types=1);

namespace A50\Http\Router;

use InvalidArgumentException;
use Psr\Http\Server\RequestHandlerInterface;
use Webmozart\Assert\Assert;

final class Route
{
    private const GET = 'GET';
    private const POST = 'POST';
    private const PUT = 'PUT';
    private const PATCH = 'PATCH';
    private const DELETE = 'DELETE';

    /** @var non-empty-string */
    private string $httpMethod;
    /** @var non-empty-string */
    private string $path;
    /** @var non-empty-string */
    private string $handler;
    /** @var non-empty-string|null */
    private ?string $name;
    /** @var array<class-string> */
    private array $middlewares = [];

    /**
     * @param class-string<RequestHandlerInterface> $handler
     */
    private function __construct(string $httpMethod, string $path, string $handler, ?string $name = null)
    {
        Assert::stringNotEmpty($httpMethod);
        Assert::inArray($httpMethod, [
            self::GET,
            self::POST,
            self::PUT,
            self::PATCH,
            self::DELETE,
        ]);
        Assert::stringNotEmpty($path);
        Assert::stringNotEmpty($handler);

        if (!in_array('Psr\Http\Server\RequestHandlerInterface', class_implements($handler), true)) {
            throw new InvalidArgumentException(\sprintf('Class %s must implements Psr\Http\Server\RequestHandlerInterface', $handler));
        }

        if ($name !== null) {
            Assert::stringNotEmpty($name);
        }

        $this->httpMethod = $httpMethod;
        $this->path = $path;
        $this->handler = $handler;
        $this->name = $name;
    }

    /**
     * @param non-empty-string $route
     * @param class-string<RequestHandlerInterface> $handler
     * @return static
     */
    public static function get(string $route, string $handler, ?string $name = null): self
    {
        return new self(self::GET, $route, $handler, $name);
    }

    /**
     * @param non-empty-string $route
     * @param class-string<RequestHandlerInterface> $handler
     * @return static
     */
    public static function post(string $route, string $handler, ?string $name = null): self
    {
        return new self(self::POST, $route, $handler);
    }

    /**
     * @param non-empty-string $route
     * @param class-string<RequestHandlerInterface> $handler
     * @return static
     */
    public static function put(string $route, string $handler, ?string $name = null): self
    {
        return new self(self::PUT, $route, $handler);
    }

    /**
     * @param non-empty-string $route
     * @param class-string<RequestHandlerInterface> $handler
     * @return static
     */
    public static function patch(string $route, string $handler, ?string $name = null): self
    {
        return new self(self::PATCH, $route, $handler);
    }

    /**
     * @param non-empty-string $route
     * @param class-string<RequestHandlerInterface> $handler
     * @return static
     */
    public static function delete(string $route, string $handler, ?string $name = null): self
    {
        return new self(self::DELETE, $route, $handler);
    }

    /**
     * @return non-empty-string
     */
    public function httpMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * @return non-empty-string
     */
    public function path(): string
    {
        return $this->path;
    }

    /**
     * @return non-empty-string
     */
    public function handler(): string
    {
        return $this->handler;
    }

    /**
     * @param class-string $middlewareClassName
     */
    public function withMiddleware(string $middlewareClassName): Route
    {
        $new = clone $this;
        $new->middlewares[] = $middlewareClassName;

        return $new;
    }

    /**
     * @return array<class-string>
     */
    public function middlewares(): array
    {
        return $this->middlewares;
    }

    public function withName(string $name): Route
    {
        Assert::notEmpty($name);

        $new = clone $this;
        $new->name = $name;

        return $new;
    }

    /**
     * @return non-empty-string|null
     */
    public function name(): ?string
    {
        return $this->name;
    }
}
