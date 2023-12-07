<?php

declare(strict_types=1);

namespace A50\Environment;

use Webmozart\Assert\Assert;

final class EnvironmentConfig
{
    private function __construct(
        /**
         * @var array<string>
         */
        private array $requiredFields,
    ) {
    }

    /**
     * @param array<string> $requiredFields
     * @return static
     */
    public static function withDefaults(
        array $requiredFields = [],
    ): self {
        return new self($requiredFields);
    }

    public function withRequiredField(string $name): self
    {
        Assert::notEmpty($name);

        $new = clone $this;
        $new->requiredFields[] = $name;

        return $new;
    }

    /**
     * @return string[]|null
     */
    public function requiredFields(): ?array
    {
        return $this->requiredFields;
    }
}
