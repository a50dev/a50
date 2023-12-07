<?php

declare(strict_types=1);

namespace A50\Filesystem\Flysystem;

use A50\Container\ServiceProvider;
use A50\Filesystem\FilesystemConfig;
use Aws\S3\S3Client;
use Aws\S3\S3ClientInterface;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\Filesystem;
use Psr\Container\ContainerInterface;

final class FlysystemProvider implements ServiceProvider
{
    public static function getDefinitions(): array
    {
        return [
            FilesystemConfig::class => static fn () => FilesystemConfig::withDefaults(),
            Filesystem::class => static function (ContainerInterface $container): Filesystem {
                /** @var FilesystemConfig $config */
                $config = $container->get(FilesystemConfig::class);
                /** @var S3ClientInterface $client */
                $client = new S3Client($config->s3Options());

                // The internal adapter
                $adapter = new AwsS3V3Adapter(
                    // S3Client
                    $client,
                    // Bucket name
                    $config->bucketName(),
                );

                // The FilesystemOperator
                return new Filesystem($adapter);
            },
        ];
    }

    public static function getExtensions(): array
    {
        return [];
    }
}
