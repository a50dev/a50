<?php

declare(strict_types=1);

namespace A50\Container\Tests\Datasets\Factory;

use Psr\Container\ContainerInterface;

final class FooFactory
{
    public function __invoke(
        ContainerInterface $container
    ): Foo {
        return new SimpleFoo('foo');
    }
}
