<?php

declare(strict_types=1);

namespace A50\ErrorHandler;

use Whoops\Handler\PlainTextHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\RunInterface;

final class WhoopsErrorHandler implements ErrorHandler
{
    public function __construct(
        private RunInterface $whoops,
        private bool $catchExceptions,
    ) {
    }

    public function register(): void
    {
        if (!$this->catchExceptions) {
            return;
        }

        if (self::isCli()) {
            $this->whoops->pushHandler(new PlainTextHandler());
        } else {
            $this->whoops->pushHandler(new PrettyPageHandler());
        }

        $this->whoops->register();
    }

    private static function isCli(): bool
    {
        return php_sapi_name() === 'cli';
    }
}
