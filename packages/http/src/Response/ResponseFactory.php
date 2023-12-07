<?php

declare(strict_types=1);

namespace A50\Http\Response;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

interface ResponseFactory
{
    /**
     * Default flags for json_encode; value of:
     *
     * <code>
     * JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES
     * </code>
     *
     * @const int
     */
    public const DEFAULT_JSON_FLAGS = 79;

    /**
     * Create a redirect response.
     *
     * Produces a redirect response with a Location header and the given status
     * (302 by default).
     *
     * Note: this method overwrites the `location` $headers value.
     *
     * @param string|UriInterface $uri URI for the Location header.
     * @param StatusCode $statusCode Status code for the redirect; 302 by default.
     * @param array<string, string> $headers Array of headers to use at initialization.
     */
    public static function redirect(string|UriInterface $uri, StatusCode $statusCode = StatusCode::HTTP_FOUND, array $headers = []): ResponseInterface;

    /**
     * Create a JSON response with the given data.
     *
     * Default JSON encoding is performed with the following options, which
     * produces RFC4627-compliant JSON, capable of embedding into HTML.
     *
     * - JSON_HEX_TAG
     * - JSON_HEX_APOS
     * - JSON_HEX_AMP
     * - JSON_HEX_QUOT
     * - JSON_UNESCAPED_SLASHES
     *
     * @param mixed $data Data to convert to JSON.
     * @param StatusCode $statusCode Status code for the response; 200 by default.
     * @param array<string, string> $headers Array of headers to use at initialization.
     * @param int $encodingOptions JSON encoding options to use.
     * @throws InvalidArgumentException if unable to encode the $data to JSON.
     */
    public static function json(
        mixed      $data,
        StatusCode $statusCode = StatusCode::HTTP_OK,
        array      $headers = [],
        int        $encodingOptions = self::DEFAULT_JSON_FLAGS
    ): ResponseInterface;

    /**
     * Create an empty response with the given status code.
     *
     * @param StatusCode $statusCode Status code for the response, if any.
     * @param array<string, string> $headers Headers for the response, if any.
     */
    public static function empty(StatusCode $statusCode = StatusCode::HTTP_NO_CONTENT, array $headers = []): ResponseInterface;

    /**
     * Create an HTML response.
     *
     * Produces an HTML response with a Content-Type of text/html and a default
     * status of 200.
     *
     * @param StreamInterface|string $html HTML or stream for the message body.
     * @param StatusCode $statusCode Status code for the response; 200 by default.
     * @param array<string, string> $headers Array of headers to use at initialization.
     * @throws InvalidArgumentException if $html is neither a string or stream.
     */
    public static function html(string|StreamInterface $html, StatusCode $statusCode = StatusCode::HTTP_OK, array $headers = []): ResponseInterface;
}
