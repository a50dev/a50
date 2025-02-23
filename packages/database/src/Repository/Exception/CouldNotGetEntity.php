<?php

declare(strict_types=1);

namespace A50\Database\Repository\Exception;

use RuntimeException;

final class CouldNotGetEntity extends RuntimeException
{
    public static function becauseOf(
        string $reason,
    ): self {
        return new self(
            sprintf(
                'Could not find an entity because: "%s"',
                $reason,
            )
        );
    }
}
