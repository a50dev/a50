<?php

declare(strict_types=1);

namespace A50\Container\Tests\Datasets\AutowireInterfaces;

final class FooUsingBar implements Foo
{
    public function __construct(
        private readonly Bar $bar
    ) {
    }

    public function bar(): Bar
    {
        return $this->bar;
    }
}
