<?php

declare(strict_types=1);

namespace A50\Environment;

use RuntimeException;

use A50\Directories\Directories;

use function file_exists;
use function mb_strtolower;
use function trim;

final class EnvironmentValuesUsingEnv implements Environment
{
    public function __construct(
        private readonly Directories $directories,
    ) {
    }

    private const VALUE_MAP = [
        'true' => true,
        '(true)' => true,
        'false' => false,
        '(false)' => false,
        'empty' => '',
    ];

    private function normalize(bool|int|string $value): bool|int|string
    {
        $alias = mb_strtolower((string)$value);
        if (isset(self::VALUE_MAP[$alias])) {
            return self::VALUE_MAP[$alias];
        }

        return $value;
    }

    public function get(string $name, bool|int|null|string $default = null): bool|int|string
    {
        $value = $_ENV[$name] ?? null;

        if ($value !== null) {
            return $this->normalize($value);
        }

        $filePath = $_ENV[$name . '_FILE'] ?? null;

        if ($filePath !== null) {
            $separator = \DIRECTORY_SEPARATOR;
            $parts = \explode($separator, $filePath);

            $alias = $this->directories->get($parts[0]);
            $realPath = \implode($separator, [
                rtrim($alias, $separator),
                ...array_slice($parts, 1),
            ]);

            $fileExists = file_exists($realPath);
            $fileContent = file_get_contents($realPath);

            if ($fileExists && $fileContent && $trimmedContent = trim($fileContent)) {
                return $trimmedContent;
            }
        }

        if ($default !== null) {
            return $default;
        }

        throw new RuntimeException('Undefined env ' . $name);
    }
}
