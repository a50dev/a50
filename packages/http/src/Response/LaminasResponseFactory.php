<?php

declare(strict_types=1);

namespace A50\Http\Response;

use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;

final class LaminasResponseFactory implements ResponseFactory
{
    /**
     * @param array<string, string> $headers
     */
    public static function redirect($uri, StatusCode $statusCode = StatusCode::HTTP_FOUND, array $headers = []): ResponseInterface
    {
        return new RedirectResponse($uri, $statusCode->value, $headers);
    }

    /**
     * @param array<string, string> $headers
     */
    public static function json(
        $data,
        StatusCode $statusCode = StatusCode::HTTP_OK,
        array      $headers = [],
        int        $encodingOptions = self::DEFAULT_JSON_FLAGS
    ): ResponseInterface {
        return new JsonResponse($data, $statusCode->value, $headers, $encodingOptions);
    }

    /**
     * @param array<string, string> $headers
     */
    public static function empty(StatusCode $statusCode = StatusCode::HTTP_NO_CONTENT, array $headers = []): ResponseInterface
    {
        return new EmptyResponse($statusCode->value, $headers);
    }

    /**
     * @param array<string, string> $headers
     */
    public static function html($html, StatusCode $statusCode = StatusCode::HTTP_OK, array $headers = []): ResponseInterface
    {
        return new HtmlResponse($html, $statusCode->value, $headers);
    }
}
