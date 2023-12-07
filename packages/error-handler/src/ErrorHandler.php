<?php

declare(strict_types=1);

namespace A50\ErrorHandler;

interface ErrorHandler
{
    public function register(): void;
}
