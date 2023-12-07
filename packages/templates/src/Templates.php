<?php

declare(strict_types=1);

namespace A50\Templates;

interface Templates
{
    /**
     * Get file template extension.
     */
    public function getExtension(): string;

    /**
     * Renders a template.
     * @param string $name The template name
     */
    public function render(string $name, array $context = []): string;
}
