<?php

/**
 * This file is part of the ramsey/uuid library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Ben Ramsey <ben@benramsey.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace Ramsey\Uuid\Converter;

/**
 * A time converter converts timestamps into representations that may be used
 * in UUIDs
 */
interface TimeConverterInterface
{
    /**
     * Uses the provided seconds and micro-seconds to calculate the time_low,
     * time_mid, and time_high fields used by RFC 4122 version 1 UUIDs
     *
     * @param string $seconds
     * @param string $microSeconds
     * @return string[] An array guaranteed to contain `low`, `mid`, and `high` keys
     * @link http://tools.ietf.org/html/rfc4122#section-4.2.2 RFC 4122, § 4.2.2: Generation Details
     */
    public function calculateTime(string $seconds, string $microSeconds): array;

    /**
     * Converts a timestamp extracted from a UUID to a unix timestamp
     *
     * @param string $timestamp A string integer representation of a timestamp;
     *     this must be a numeric string to accommodate unsigned integers
     *     greater than PHP_INT_MAX.
     * @return string
     */
    public function convertTime(string $timestamp): string;
}
