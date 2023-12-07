<?php

declare(strict_types=1);

namespace A50\Environment;

use Psr\Container\ContainerInterface;
use RuntimeException;
use A50\Container\ServiceProvider;
use A50\Directories\Directories;

final class EnvironmentServiceProvider implements ServiceProvider
{
    public static function getDefinitions(): array
    {
        return [
            Environment::class => static function (ContainerInterface $container) {
                /** @var EnvironmentConfig $config */
                $config = $container->get(EnvironmentConfig::class);
                /** @var Directories $directories */
                $directories = $container->get(Directories::class);

                $environment = new EnvironmentValuesUsingEnv($directories);

                if ($config->requiredFields()) {
                    $requiredFields = [];
                    foreach ($config->requiredFields() as $requiredField) {
                        $isExists = $environment->get($requiredField);

                        if (!$isExists) {
                            $requiredFields[] = $requiredField;
                        }
                    }

                    if (!empty($requiredFields)) {
                        $fieldsToDefined = \implode(', ', $requiredFields);

                        throw new RuntimeException('These fields must be defined: ' . $fieldsToDefined);
                    }
                }

                return $environment;
            },
            CurrentEnvironment::class => static fn () => new CurrentEnvironment(EnvironmentName::PRODUCTION),
            EnvironmentConfig::class => static fn () => EnvironmentConfig::withDefaults(),
        ];
    }

    public static function getExtensions(): array
    {
        return [];
    }
}
