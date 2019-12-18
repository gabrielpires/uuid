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

namespace Ramsey\Uuid\Converter\Time;

use InvalidArgumentException;
use Moontoast\Math\BigNumber;
use Ramsey\Uuid\Converter\DependencyCheckTrait;
use Ramsey\Uuid\Converter\NumberStringTrait;
use Ramsey\Uuid\Converter\TimeConverterInterface;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

/**
 * BigNumberTimeConverter uses the moontoast/math library's `BigNumber` to
 * provide facilities for converting parts of time into representations that may
 * be used in UUIDs
 */
class BigNumberTimeConverter implements TimeConverterInterface
{
    use DependencyCheckTrait;
    use NumberStringTrait;

    /**
     * Uses the provided seconds and micro-seconds to calculate the time_low,
     * time_mid, and time_high fields used by RFC 4122 version 1 UUIDs
     *
     * @param string $seconds
     * @param string $microSeconds
     * @return string[] An array guaranteed to contain `low`, `mid`, and `high` keys
     * @throws InvalidArgumentException if $seconds or $microseconds are not integer strings
     * @throws UnsatisfiedDependencyException if the chosen converter is not present
     * @link http://tools.ietf.org/html/rfc4122#section-4.2.2
     */
    public function calculateTime(string $seconds, string $microSeconds): array
    {
        $this->checkMoontoastMathLibrary();
        $this->checkIntegerString($seconds, 'seconds');
        $this->checkIntegerString($microSeconds, 'microSeconds');

        $uuidTime = new BigNumber('0');

        $sec = new BigNumber($seconds);
        $sec->multiply('10000000');

        $usec = new BigNumber($microSeconds);
        $usec->multiply('10');

        $uuidTime
            ->add($sec)
            ->add($usec)
            ->add('122192928000000000');

        $uuidTimeHex = sprintf('%016s', $uuidTime->convertToBase(16));

        return [
            'low' => substr($uuidTimeHex, 8),
            'mid' => substr($uuidTimeHex, 4, 4),
            'hi' => substr($uuidTimeHex, 0, 4),
        ];
    }

    /**
     * Converts a timestamp extracted from a UUID to a unix timestamp
     *
     * @param string $timestamp A string integer representation of a timestamp;
     *     this must be a numeric string to accommodate unsigned integers
     *     greater than PHP_INT_MAX.
     * @return string
     * @throws InvalidArgumentException if $timestamp is not an integer string
     * @throws UnsatisfiedDependencyException if the chosen converter is not present
     */
    public function convertTime(string $timestamp): string
    {
        $this->checkMoontoastMathLibrary();
        $this->checkIntegerString($timestamp, 'timestamp');

        $ts = new BigNumber($timestamp, 20);
        $ts->subtract('122192928000000000');
        $ts->divide('10000000.0');
        $ts->round();

        return $ts->getValue();
    }
}
