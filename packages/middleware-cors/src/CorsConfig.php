<?php

declare(strict_types=1);

namespace A50\Middleware\Cors;

final class CorsConfig
{
    private function __construct(
        private array $allowedHeaders,
        private array $allowedMethods,
        private array $allowedOrigins,
        private array $allowedOriginsPatterns,
        private array $exposedHeaders,
        private int $maxAge,
        private bool $supportsCredentials,
    ) {
    }

    public static function withDefaults(
        array $allowedHeaders = [],
        array $allowedMethods = [],
        array $allowedOrigins = [],
        array $allowedOriginsPatterns = [],
        array $exposedHeaders = [],
        int $maxAge = 0,
        bool $supportsCredentials = false,
    ): self {
        return new self(
            $allowedHeaders,
            $allowedMethods,
            $allowedOrigins,
            $allowedOriginsPatterns,
            $exposedHeaders,
            $maxAge,
            $supportsCredentials
        );
    }

    public function allowedHeaders(): array
    {
        return $this->allowedHeaders;
    }

    public function withAllowedHeaders(array $allowedHeaders): self
    {
        $new = clone $this;
        $new->allowedHeaders = $allowedHeaders;

        return $new;
    }

    public function allowedMethods(): array
    {
        return $this->allowedMethods;
    }

    public function withAllowedMethods(array $allowedMethods): self
    {
        $new = clone $this;
        $new->allowedMethods = $allowedMethods;

        return $new;
    }

    public function allowedOrigins(): array
    {
        return $this->allowedOrigins;
    }

    public function withAllowedOrigins(array $allowedOrigins): self
    {
        $new = clone $this;
        $new->allowedOrigins = $allowedOrigins;

        return $new;
    }

    public function allowedOriginsPatterns(): array
    {
        return $this->allowedOriginsPatterns;
    }

    public function exposedHeaders(): array
    {
        return $this->exposedHeaders;
    }

    public function maxAge(): int
    {
        return $this->maxAge;
    }

    public function supportsCredentials(): bool
    {
        return $this->supportsCredentials;
    }

    public function withSupportsCredentials(bool $supportsCredentials): self
    {
        $new = clone $this;
        $new->supportsCredentials = $supportsCredentials;

        return $new;
    }
}
