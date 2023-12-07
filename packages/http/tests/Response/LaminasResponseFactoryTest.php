<?php

declare(strict_types=1);

namespace A50\Http\Tests\Response;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use A50\Http\Response\LaminasResponseFactory;

/**
 * @internal
 */
final class LaminasResponseFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCreateRedirectResponse(): void
    {
        $response = LaminasResponseFactory::redirect('/');

        Assert::assertEquals('/', $response->getHeaderLine('location'));
        Assert::assertEquals(302, $response->getStatusCode());
        Assert::assertEmpty($response->getBody()->getContents());
    }

    /**
     * @test
     */
    public function shouldCreateJsonResponse(): void
    {
        $response = LaminasResponseFactory::json(['key' => 'value']);

        Assert::assertEquals('application/json', $response->getHeaderLine('Content-type'));
        Assert::assertEquals(200, $response->getStatusCode());
        Assert::assertEquals('{"key":"value"}', $response->getBody()->getContents());
    }

    /**
     * @test
     */
    public function shouldCreateEmptyResponse(): void
    {
        $response = LaminasResponseFactory::empty();

        Assert::assertEquals(204, $response->getStatusCode());
        Assert::assertEmpty($response->getBody()->getContents());
    }

    /**
     * @test
     */
    public function shouldCreateHtmlResponse(): void
    {
        $response = LaminasResponseFactory::html('<p>Some text</p>');

        Assert::assertEquals(200, $response->getStatusCode());
        Assert::assertEquals('<p>Some text</p>', $response->getBody()->getContents());
    }
}
