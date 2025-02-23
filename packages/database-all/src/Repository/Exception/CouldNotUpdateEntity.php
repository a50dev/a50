<?php

declare(strict_types=1);

namespace A50\Database\Repository\Exception;

use RuntimeException;

final class CouldNotUpdateEntity extends RuntimeException
{
    public static function withReason(
        string $message
    ): self {
        return new self(
            sprintf('Could not update an entity, because of "%s"', $message)
        );
    }
}
