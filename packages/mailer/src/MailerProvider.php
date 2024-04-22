<?php

declare(strict_types=1);

namespace A50\Mailer;

use Psr\Container\ContainerInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport\Dsn;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransportFactory;
use Symfony\Component\Mailer\Transport\TransportInterface;
use A50\Container\ServiceProvider;

final class MailerProvider implements ServiceProvider
{
    public static function getDefinitions(): array
    {
        return [
            TransportInterface::class => static function (ContainerInterface $container) {
                /** @var MailerConfig $config */
                $config = $container->get(MailerConfig::class);
                $dsn = Dsn::fromString(
                    'smtp://' . $config->user() . ':' . $config->password() . '@' . $config->host() .  ':' .
                    $config->port()
                );

                return (new EsmtpTransportFactory())->create($dsn);
            },
            MailerInterface::class => static function (ContainerInterface $container) {
                /** @var TransportInterface $transport */
                $transport = $container->get(TransportInterface::class);

                return new Mailer($transport);
            },
            MailerConfig::class => static fn () => MailerConfig::withDefaults(),
        ];
    }

    public static function getExtensions(): array
    {
        return [];
    }
}
