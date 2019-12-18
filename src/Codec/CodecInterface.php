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

namespace Ramsey\Uuid\Codec;

use Ramsey\Uuid\UuidInterface;

/**
 * A codec encodes and decodes a UUID according to defined rules
 */
interface CodecInterface
{
    /**
     * Returns a hexadecimal string representation of a UuidInterface
     *
     * @param UuidInterface $uuid
     * @return string Hexadecimal string representation of a UUID
     */
    public function encode(UuidInterface $uuid): string;

    /**
     * Returns a binary string representation of a UuidInterface
     *
     * @param UuidInterface $uuid
     * @return string Binary string representation of a UUID
     */
    public function encodeBinary(UuidInterface $uuid): string;

    /**
     * Returns a UuidInterface derived from a hexadecimal string representation
     *
     * @param string $encodedUuid
     * @return UuidInterface
     */
    public function decode(string $encodedUuid): UuidInterface;

    /**
     * Returns a UuidInterface derived from a binary string representation
     *
     * @param string $bytes
     * @return UuidInterface
     */
    public function decodeBytes(string $bytes): UuidInterface;
}
