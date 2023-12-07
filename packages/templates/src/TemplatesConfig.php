<?php

declare(strict_types=1);

namespace A50\Templates;

use Webmozart\Assert\Assert;

final class TemplatesConfig
{
    private string $templatesDirectory;
    private string $cacheDirectory;
    private bool $isDebugEnabled;

    private function __construct(
        string $templatesDirectory,
        string $cacheDirectory,
        bool $isDebugEnabled,
    ) {
        $this->templatesDirectory = $templatesDirectory;
        $this->cacheDirectory = $cacheDirectory;
        $this->isDebugEnabled = $isDebugEnabled;
    }

    public static function withDefaults(
        string $templatesDirectory = '@templates',
        string $cacheDirectory = '@cache',
        bool $isDebugEnabled = false,
    ): self {
        return new self($templatesDirectory, $cacheDirectory, $isDebugEnabled);
    }

    public function templatesDirectory(): string
    {
        return $this->templatesDirectory;
    }

    public function withTemplatesDirectory(string $templatesDirectory): self
    {
        Assert::notEmpty($templatesDirectory);
        $new = clone $this;
        $new->templatesDirectory = $templatesDirectory;

        return $new;
    }

    public function cacheDirectory(): string
    {
        return $this->cacheDirectory;
    }

    public function withCacheDirectory(string $cacheDirectory): self
    {
        Assert::notEmpty($cacheDirectory);
        $new = clone $this;
        $new->cacheDirectory = $cacheDirectory;

        return $new;
    }

    public function isDebugEnabled(): bool
    {
        return $this->isDebugEnabled;
    }

    public function withDebugEnabled(bool $isDebugEnabled): self
    {
        $new = clone $this;
        $new->isDebugEnabled = $isDebugEnabled;

        return $new;
    }
}
