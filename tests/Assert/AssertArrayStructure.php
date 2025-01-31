<?php

declare(strict_types=1);

namespace App\Tests\Assert;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\ExpectationFailedException;

class AssertArrayStructure extends Assert
{
    /**
     * @param mixed $expected
     * @param mixed $actual
     */
    public static function assert(mixed $expected, mixed $actual): void
    {
        foreach ($expected['fields'] as $key => $expectation) {
            if (($expectation['optional'] ?? false) && !isset($actual[$key])) {
                continue;
            }
            self::assertArrayHasKey($key, $actual, json_encode($actual));
            if (isset($expectation['type'])) {
                self::assertType($expectation['type'], $actual[$key]);
            }
            if (isset($expectation['isNull'])) {
                $expectation['isNull'] ? self::assertNull($actual[$key]) : self::assertNotNull($actual[$key]);
            }
            if (isset($expectation['isNumeric'])) {
                $expectation['isNumeric'] ? self::assertIsNumeric($actual[$key]) : self::assertIsNotNumeric($actual[$key]);
            }
            if (isset($expectation['elements'])) {
                foreach ($actual[$key] as $item) {
                    if (isset($expectation['elements']['type'])) {
                        self::assertType($expectation['elements']['type'], $item);
                    }
                    if (!isset($expectation['elements']['fields'])) {
                        continue;
                    }
                    self::assert($expectation['elements'], $item);
                }
            }

            if (isset($expectation['fields'])) {
                self::assert($expectation, $actual[$key]);
            }
        }
    }

    /**
     * @param array $expectation
     * @param mixed $item
     */
    public static function assertElements(array $expectation, mixed $item): void
    {
        if (isset($expectation['elements']['type'])) {
            self::assertType($expectation['elements']['type'], $item);
        }
        if (!isset($expectation['elements']['fields'])) {
            return;
        }
        self::assert($expectation['elements'], $item);
    }

    /**
     * @param array|string $expected
     * @param              $actual
     */
    private static function assertType(array|string $expected, $actual): void
    {
        if (is_string($expected)) {
            $expected = [$expected];
        }
        foreach ($expected as $expect) {
            try {
                self::assertEquals($expect, gettype($actual), sprintf("%f : Actual should be a %s, get %s instead", json_encode($actual), $expect, gettype($actual)));
            } catch (ExpectationFailedException) {
                continue;
            }

            return;
        }
        self::fail("no type valid for : " . implode(", ", $expected) . " and " . json_encode($actual));
    }
}
