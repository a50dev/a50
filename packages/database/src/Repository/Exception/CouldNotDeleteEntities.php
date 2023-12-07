<?php

declare(strict_types=1);

namespace A50\Database\Repository\Exception;

use RuntimeException;

final class CouldNotDeleteEntities extends RuntimeException
{
    public static function withReason(
        string $message
    ): self {
        return new self(
            sprintf('Could not delete the entities, because of "%s"', $message)
        );
    }
}
