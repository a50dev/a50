<?php

declare(strict_types=1);

namespace A50\Directories;

use A50\Directories\Exception\CouldNotFindDirectoryWithAlias;

final class FilesystemDirectories implements Directories
{
    /**
     * @param array<string, string> $directories
     */
    private function __construct(
        private array $directories,
    ) {
    }

    public static function fromConfig(DirectoriesConfig $config): self
    {
        return new self(
            $config->directories()
        );
    }

    /**
     *
     */
    public function has(string $alias): bool
    {
        return array_key_exists($alias, $this->directories);
    }

    public function get(string $alias): string
    {
        if (!$this->has($alias)) {
            throw new CouldNotFindDirectoryWithAlias(
                \sprintf('Undefined directory with alias %s', $alias)
            );
        }

        $directory = $this->directories[$alias];

        $pattern = '/^@[[:alnum:]]+/';
        $isMatched = \preg_match($pattern, $directory, $matches);
        if ($isMatched) {
            $matchedAlias = $matches[0];

            if (!$this->has($matchedAlias)) {
                throw new CouldNotFindDirectoryWithAlias(
                    \sprintf('Undefined directory with alias %s in %s', $matchedAlias, $directory)
                );
            }

            $matchedDirectory = $this->get($matchedAlias);
            $replaced = \preg_replace('/' . $matchedAlias . '/', $matchedDirectory, $directory);

            /** @phpstan-ignore-next-line */
            return str_replace(['\\', '//'], '/', $replaced);
        }

        return $directory;
    }
}
