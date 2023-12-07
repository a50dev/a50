<?php

declare(strict_types=1);

namespace A50\Http;

use Psr\Http\Server\RequestHandlerInterface;

interface Application extends RequestHandlerInterface
{
    /**
     * Run application.
     */
    public function run(): void;
}
