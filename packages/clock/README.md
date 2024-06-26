<p align="center">
    <a href="https://github.com/A50dev" target="_blank">
        <img src="https://avatars.githubusercontent.com/u/150102356" height="240px">
    </a>
    <h1 align="center">A50 Clock</h1>
    <br>
</p>

This package provides an implementation of the [PSR-20 ClockInterface](https://www.php-fig.org/psr/psr-20/).

[![Latest Version on Packagist](https://img.shields.io/packagist/v/a50/clock.svg?style=flat-square)](https://packagist.org/packages/a50/clock)
[![Tests](https://github.com/a50/clock/actions/workflows/test.yml/badge.svg?branch=main)](https://github.com/a50/clock/actions/workflows/test.yml)
[![Analysis](https://github.com/a50/clock/actions/workflows/analyse.yml/badge.svg?branch=main)](https://github.com/a50/clock/actions/workflows/analyse.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/a50/clock.svg?style=flat-square)](https://packagist.org/packages/a50/clock)

## Installation

You can install the package via composer:

```bash
composer require a50/clock
```

## Usage

Pass ClockInterface to the method in which you want to get the current date in the desired time zone:

```php
<?php

declare(strict_types=1);

namespace Project\Reviews\Application\AddReview;

use Psr\Clock\ClockInterface;
use Project\Reviews\Domain\Review;
// ...

final class Handler
{
    private ClockInterface $clock;

    public function __construct(
        ClockInterface $clock,
        // ...
    ) {
        $this->clock = $clock;
        // ...
    }

    public function __invoke(Command $command): void
    {
        $review = Review::add(
            // ...
            $this->clock->now(),
        );

        // ...
    }
}

```

or use the right one directly:

```php
<?php

declare(strict_types=1);

$clock = new TimeZoneAwareClock(new DateTimeZone('Europe/Minsk'));
$now = $clock->now();

```

If you use the `ClockServiceProvider` then the default `ClockInterface` is implemented by `TimeZoneAwareClock` with `UTC` timezone.

You can change the timezone by setting it in the config settings.

```php
<?php

declare(strict_types=1);

use A50\Container\ServiceProvider;
use A50\Clock\ClockConfig;

new class implements ServiceProvider {
    
    // ...

    /**
     * @inheritDoc
     */
    public static function getExtensions(): array
    {
        return [
            ClockConfig::class => static function ($config, ContainerInterface $container): stdClass {
                $config->withTimezone('Europe/Minsk');

                return $config;
            }
        ];
    }
}
```

## Testing

```bash
make test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Siarhei Bautrukevich](https://github.com/bautrukevich)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
