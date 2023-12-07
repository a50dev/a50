<?php

declare(strict_types=1);

namespace A50\Http\Whoops;

final class WhoopsConfig
{
    private bool $jsonExceptionsDisplay;
    private bool $jsonExceptionsShowTrace;
    private bool $jsonExceptionsAjaxOnly;
    /**
     * @var callable|Editor
     */
    private $editor;

    private function __construct(bool $jsonExceptionsDisplay, bool $jsonExceptionsShowTrace, bool $jsonExceptionsAjaxOnly, Editor|callable $editor)
    {
        $this->jsonExceptionsDisplay = $jsonExceptionsDisplay;
        $this->jsonExceptionsShowTrace = $jsonExceptionsShowTrace;
        $this->jsonExceptionsAjaxOnly = $jsonExceptionsAjaxOnly;
        $this->editor = $editor;
    }

    public static function withDefaults(bool $jsonExceptionsDisplay = true, bool $jsonExceptionsShowTrace = true, bool $jsonExceptionsAjaxOnly = true, Editor|callable $editor = Editor::PhpStorm): self
    {
        return new self($jsonExceptionsDisplay, $jsonExceptionsShowTrace, $jsonExceptionsAjaxOnly, $editor);
    }

    public function jsonExceptionsDisplay(): bool
    {
        return $this->jsonExceptionsDisplay;
    }

    public function withJsonExceptionsDisplay(bool $value): self
    {
        $new = clone $this;
        $new->jsonExceptionsDisplay = $value;

        return $new;
    }

    public function jsonExceptionsShowTrace(): bool
    {
        return $this->jsonExceptionsShowTrace;
    }

    public function withJsonExceptionsShowTrace(bool $value): self
    {
        $new = clone $this;
        $new->jsonExceptionsShowTrace = $value;

        return $new;
    }

    public function jsonExceptionsAjaxOnly(): bool
    {
        return $this->jsonExceptionsAjaxOnly;
    }

    public function withJsonExceptionsAjaxOnly(bool $value): self
    {
        $new = clone $this;
        $new->jsonExceptionsAjaxOnly = $value;

        return $new;
    }

    /**
     */
    public function editor(): Editor|callable
    {
        return $this->editor;
    }

    public function withEditor(Editor|callable $editor): self
    {
        $new = clone $this;
        $new->editor = $editor;

        return $new;
    }
}
