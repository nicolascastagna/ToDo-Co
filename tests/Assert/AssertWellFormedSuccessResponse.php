<?php

declare(strict_types=1);

namespace App\Tests\Assert;

use PHPUnit\Framework\Assert;

class AssertWellFormedSuccessResponse extends Assert
{
    /**
     * @param array $content
     */
    public static function assert(array $content): void
    {
        self::assertIsArray($content);
        self::assertArrayHasKey('data', $content);
        self::assertArrayHasKey('status', $content);
        self::assertIsInt($content['status']);
        self::assertIsArray($content['data']);
    }
}
