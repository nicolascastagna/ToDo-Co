<?php

declare(strict_types=1);

namespace App\Tests\Assert;

use const JSON_THROW_ON_ERROR;
use JsonException;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

class AssertResponse extends Assert
{
    /**
     * @param Response $response
     * @param string   $message
     */
    public static function assertConflictResponse(Response $response, string $message = ''): void
    {
        self::assertResponse(Response::HTTP_CONFLICT, $response, $message);
    }

    /**
     * @param Response $response
     * @param string   $message
     */
    public static function assertOK(Response $response, string $message = ''): void
    {
        self::assertResponse(Response::HTTP_OK, $response, $message);
    }

    /**
     * @param Response $response
     * @param string   $message
     */
    public static function assertUnprocessable(Response $response, string $message = ''): void
    {
        self::assertResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $response, $message);
    }

    /**
     * @param Response $response
     * @param string   $message
     */
    public static function assertNotFound(Response $response, string $message = ''): void
    {
        self::assertResponse(Response::HTTP_NOT_FOUND, $response, $message);
    }

    /**
     * @param Response $response
     * @param string   $message
     */
    public static function assertForbidden(Response $response, string $message = ''): void
    {
        self::assertResponse(Response::HTTP_FORBIDDEN, $response, $message);
    }

    /**
     * @param Response $response
     * @param string   $message
     */
    public static function assertBadRequest(Response $response, string $message = ''): void
    {
        self::assertResponse(Response::HTTP_BAD_REQUEST, $response, $message);
    }

    /**
     * @param Response $response
     * @param string   $message
     */
    public static function assertCreated(Response $response, string $message = ''): void
    {
        self::assertResponse(Response::HTTP_CREATED, $response, $message);
    }

    /**
     * @param Response $response
     * @param string   $message
     */
    public static function assertUnauthorizedResponse(Response $response, string $message = ''): void
    {
        self::assertResponse(Response::HTTP_UNAUTHORIZED, $response, $message);
    }

    /**
     * @param array    $expected
     * @param Response $response
     *
     * @throws JsonException
     */
    public static function responseAreSameAs(array $expected, Response $response): void
    {
        if (isset($expected['status'])) {
            self::assertSame($expected['status'], $response->getStatusCode(), $response->getContent());
        }
        $responseContent = json_decode($response->getContent(), true, flags: JSON_THROW_ON_ERROR);
        self::assertArrayHasKey('data', $responseContent);

        $data = $responseContent['data'];
        foreach ($expected['data'] as $key => $value) {
            self::assertArrayHasKey($key, $data, json_encode($data));
            if ('id' === $key) {
                self::assertNotNull($data[$key]);

                continue;
            }
            self::assertSame($value, $data[$key], $response->getContent());
        }
    }

    /**
     * @param int      $statusCode
     * @param Response $response
     * @param string   $message
     */
    private static function assertResponse(int $statusCode, Response $response, string $message = ''): void
    {
        self::assertSame($statusCode, $response->getStatusCode(), $message);
    }
}
