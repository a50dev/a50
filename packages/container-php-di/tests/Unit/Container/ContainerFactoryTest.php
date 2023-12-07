<?php

declare(strict_types=1);

namespace A50\Container\Tests\Unit\Container;

use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use stdClass;
use A50\Container\ContainerFactory;
use A50\Container\Tests\Datasets\AutowireInterfaces\Bar;
use A50\Container\Tests\Datasets\AutowireInterfaces\CanAutowireInterfacesServiceProvider;
use A50\Container\Tests\Datasets\AutowireInterfaces\Foo;
use A50\Container\Tests\Datasets\AutowireInterfaces\FooUsingBar;
use A50\Container\Tests\Datasets\DefinitionsIsNotCallableServiceProvider;
use A50\Container\Tests\Datasets\EmptyServiceProvider;
use A50\Container\Tests\Datasets\ExtensionsIsNotCallableServiceProvider;
use A50\Container\Tests\Datasets\Factory\FactoryServiceProvider;
use A50\Container\Tests\Datasets\Factory\SimpleFoo;
use A50\Container\Tests\Datasets\SimpleServiceProvider;

/**
 * @internal
 */
final class ContainerFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function shouldThrowExceptionIfArrayOfProvidersIsEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new ContainerFactory())->build([]);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionIfDefinitionsIsNotServiceProvider(): void
    {
        $this->expectException(InvalidArgumentException::class);
        /* @phpstan-ignore-next-line */
        (new ContainerFactory())->build([
            stdClass::class,
        ]);
    }

    /**
     * @test
     * @throws Exception
     */
    public function shouldThrowExceptionIfDefinitionsAndExtensionsWereNotProvided(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new ContainerFactory())->build([
            EmptyServiceProvider::class,
        ]);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionIfDefinitionsIsNotCallable(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new ContainerFactory())->build([
            DefinitionsIsNotCallableServiceProvider::class,
        ]);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionIfExtensionsIsNotCallable(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new ContainerFactory())->build([
            ExtensionsIsNotCallableServiceProvider::class,
        ]);
    }

    /**
     * @test
     * @throws Exception
     */
    public function shouldCreatePsrContainerFromArrayOfServiceProviders(): void
    {
        $container = (new ContainerFactory())->build([
            SimpleServiceProvider::class,
        ]);

        Assert::assertInstanceOf(ContainerInterface::class, $container);
    }

    /**
     * @test
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function shouldCreatePsrContainerIfDefinitionValueImplementsInterface(): void
    {
        $container = (new ContainerFactory())->build([
            CanAutowireInterfacesServiceProvider::class,
        ]);

        /** @var Foo $foo */
        $foo = $container->get(Foo::class);

        Assert::assertInstanceOf(Foo::class, $foo);
        Assert::assertInstanceOf(FooUsingBar::class, $foo);
        Assert::assertInstanceOf(Bar::class, $foo->bar());
    }

    /**
     * @test
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function shouldCreatePsrContainerIfDefinitionValueIsFactory(): void
    {
        $container = (new ContainerFactory())->build([
            FactoryServiceProvider::class,
        ]);

        /** @var Foo $foo */
        $foo = $container->get(Foo::class);

        Assert::assertInstanceOf(Foo::class, $foo);
        Assert::assertInstanceOf(SimpleFoo::class, $foo);
        Assert::assertEquals('foo', $foo->value());
    }
}
