<?php

declare(strict_types=1);

namespace A50\Filesystem;

enum Driver
{
    case Local;
    case AWS;
}
