<?php

declare(strict_types=1);

namespace A50\Container\PHPDI;

use A50\Container\ServiceProvider;
use DI\ContainerBuilder;
use Exception;
use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Throwable;

use Webmozart\Assert\Assert;

use function DI\decorate;
use function DI\factory;
use function DI\get;

final class ContainerFactory
{
    private string $compilationPath;

    public function __construct(
        string $compilationPath = '',
    ) {
        $this->compilationPath = $compilationPath;
    }

    /**
     * @param class-string<ServiceProvider>[] $providers
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function build(array $providers): ContainerInterface
    {
        Assert::notEmpty($providers, 'Please, specify at least one service provider');

        $builder = new ContainerBuilder();

        if ($this->compilationPath !== '') {
            if (\apcu_enabled()) {
                $builder->enableDefinitionCache();
            }
            $builder->enableCompilation($this->compilationPath);
        }

        foreach ($providers as $providerClassName) {
            if (!is_a($providerClassName, ServiceProvider::class, true)) {
                throw new InvalidArgumentException(sprintf(
                    'Class "%s" was expected to implement "%s"',
                    $providerClassName,
                    ServiceProvider::class
                ));
            }

            $definitions = $providerClassName::getDefinitions();
            $extensions = $providerClassName::getExtensions();

            if (empty($definitions) && empty($extensions)) {
                throw new InvalidArgumentException(
                    \sprintf('Please, specify definitions or extensions in %s', $providerClassName)
                );
            }

            $factories = [];

            foreach ($definitions as $definitionClassName => $callable) {
                if (\is_callable($callable)) {
                    $factories[$definitionClassName] = factory($callable);
                    continue;
                }

                if (\method_exists($callable, '__invoke')) {
                    $factories[$definitionClassName] = factory([$callable, '__invoke']);
                    continue;
                }

                $isCallableImplementsDefinition = is_a($callable, $definitionClassName, true);
                if ($isCallableImplementsDefinition) {
                    try {
                        $factories[$definitionClassName] = get($callable);
                        continue;
                    } catch (Throwable $throwable) {
                        throw new InvalidArgumentException($throwable->getMessage());
                    }
                }

                throw new InvalidArgumentException(\sprintf('Definition of %s must be `callable` or interface implementation', $definitionClassName));
            }

            $builder->addDefinitions($factories);

            if (empty($extensions)) {
                continue;
            }

            $decorated = [];
            foreach ($extensions as $extensionClassName => $callable) {
                /** @psalm-suppress RedundantConditionGivenDocblockType */
                Assert::isCallable($callable, \sprintf('Extension of %s must be `callable`', $extensionClassName));

                $decorated[$extensionClassName] = decorate($callable);
            }

            $builder->addDefinitions($decorated);
        }

        return $builder->build();
    }
}
