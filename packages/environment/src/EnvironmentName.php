<?php

declare(strict_types=1);

namespace A50\Environment;

enum EnvironmentName: string
{
    case PRODUCTION = 'prod';
    case DEVELOPMENT = 'dev';
    case TEST = 'test';
}
