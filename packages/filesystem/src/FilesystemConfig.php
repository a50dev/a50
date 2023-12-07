<?php

declare(strict_types=1);

namespace A50\Filesystem;

final class FilesystemConfig
{
    public function __construct(
        private readonly string $bucketName,
        private readonly array $s3Options,
    ) {
    }

    public static function withDefaults(
        string $bucketName = 'PLEASE-CHANGE-BUCKET-NAME',
        array $s3Options = [],
    ): self {
        return new self($bucketName, $s3Options);
    }

    public function bucketName(): string
    {
        return $this->bucketName;
    }

    public function withBucketName($bucketName): self
    {
        return new self($bucketName, $this->s3Options);
    }

    public function s3Options(): array
    {
        return $this->s3Options;
    }

    public function withS3Options($s3Options): self
    {
        return new self($this->bucketName, $s3Options);
    }
}
