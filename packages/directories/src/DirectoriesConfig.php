<?php

declare(strict_types=1);

namespace A50\Directories;

use Webmozart\Assert\Assert;
use A50\Directories\Exception\DirectoryWithAliasAlreadyExists;

final class DirectoriesConfig
{
    /**
     * @var array<string, string>
     */
    private array $directories = [];

    private function __construct()
    {
    }

    /**
     * @param array<string, string> $directories
     * @return static
     */
    public static function withDefaults(array $directories = []): self
    {
        $self = new self();

        foreach ($directories as $alias => $path) {
            Assert::string($alias);
            Assert::string($path);

            $self = $self->withDirectory($alias, $path);
        }

        return $self;
    }

    /**
     * @return array<string, string>
     */
    public function directories(): array
    {
        return $this->directories;
    }

    /**
     * @param string $alias Directory alias, ie. "@public".
     * @param string $path Directory path without ending slash.
     * @param bool $rewrite Ability to rewrite path with existing alias.
     */
    public function withDirectory(string $alias, string $path, bool $rewrite = false): self
    {
        Assert::notEmpty($alias);
        Assert::notEmpty($path);

        $new = clone $this;

        $path = str_replace(['\\', '//'], '/', $path);

        $hasDirectory = array_key_exists($alias, $new->directories);
        if ($hasDirectory && !$rewrite) {
            throw new DirectoryWithAliasAlreadyExists(
                \sprintf('Directory alias "%s" already exists with "%s" path', $alias, $path)
            );
        }

        $new->directories[$alias] = rtrim($path, '/') . '/';

        return $new;
    }
}
