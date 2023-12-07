<?php

declare(strict_types=1);

namespace A50\Http\Tests\Whoops;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use A50\Http\Whoops\Editor;
use A50\Http\Whoops\WhoopsConfig;

/**
 * @internal
 */
final class WhoopsConfigTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCanBeCreatedWithDefaults(): void
    {
        $config = WhoopsConfig::withDefaults();

        Assert::assertTrue($config->jsonExceptionsDisplay());
        Assert::assertTrue($config->jsonExceptionsShowTrace());
        Assert::assertTrue($config->jsonExceptionsAjaxOnly());
        Assert::assertEquals(Editor::PhpStorm, $config->editor());
    }

    /**
     * @test
     */
    public function shouldCanChangeJsonExceptionsDisplayValue(): void
    {
        $config = WhoopsConfig::withDefaults();

        $newConfig = $config->withJsonExceptionsDisplay(false);
        Assert::assertFalse($newConfig->jsonExceptionsDisplay());

        $newConfig = $config->withJsonExceptionsDisplay(true);
        Assert::assertTrue($newConfig->jsonExceptionsDisplay());
    }

    /**
     * @test
     */
    public function shouldCanChangeJsonExceptionsShowTraceValue(): void
    {
        $config = WhoopsConfig::withDefaults();

        $newConfig = $config->withJsonExceptionsShowTrace(false);
        Assert::assertFalse($newConfig->jsonExceptionsShowTrace());

        $newConfig = $config->withJsonExceptionsShowTrace(true);
        Assert::assertTrue($newConfig->jsonExceptionsShowTrace());
    }

    /**
     * @test
     */
    public function shouldCanChangeJsonExceptionsAjaxOnlyValue(): void
    {
        $config = WhoopsConfig::withDefaults();

        $newConfig = $config->withJsonExceptionsAjaxOnly(false);
        Assert::assertFalse($newConfig->jsonExceptionsAjaxOnly());

        $newConfig = $config->withJsonExceptionsAjaxOnly(true);
        Assert::assertTrue($newConfig->jsonExceptionsAjaxOnly());
    }

    /**
     * @test
     */
    public function shouldCanChangeEditorValue(): void
    {
        $config = WhoopsConfig::withDefaults();

        $newConfig = $config->withEditor(Editor::VSCode);
        Assert::assertEquals(Editor::VSCode, $newConfig->editor());

        $callable = static fn ($file, $line) => "whatever://open?file=$file&line=$line";
        $newConfig = $config->withEditor($callable);
        Assert::assertEquals($callable, $newConfig->editor());
    }
}
