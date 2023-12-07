<?php

declare(strict_types=1);

namespace A50\Directories;

use A50\Directories\Exception\CouldNotFindDirectoryWithAlias;

interface Directories
{
    /**
     * Check if directory exists.
     */
    public function has(string $alias): bool;

    /**
     * Get directory.
     * @throws CouldNotFindDirectoryWithAlias When no directory found.
     */
    public function get(string $alias): string;
}
