<?php

declare(strict_types=1);

namespace A50\Container\Tests\Datasets\Factory;

final class SimpleFoo implements Foo
{
    public function __construct(
        private readonly string $value
    ) {
    }

    public function value(): string
    {
        return $this->value;
    }
}
