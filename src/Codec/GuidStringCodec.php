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

use InvalidArgumentException;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\UuidInterface;

/**
 * GuidStringCodec encodes and decodes globally unique identifiers (GUID)
 *
 * @link https://en.wikipedia.org/wiki/Globally_unique_identifier GUID
 */
class GuidStringCodec extends StringCodec
{
    /**
     * Returns a hexadecimal string representation of a GUID
     *
     * @param UuidInterface $uuid
     * @return string Hexadecimal string representation of a GUID
     */
    public function encode(UuidInterface $uuid): string
    {
        $components = array_values($uuid->getFieldsHex());

        // Swap byte-order on the first three fields.
        $this->swapFields($components);

        return vsprintf(
            '%08s-%04s-%04s-%02s%02s-%012s',
            $components
        );
    }

    /**
     * Returns a binary string representation of a GUID
     *
     * @param UuidInterface $uuid
     * @return string Binary string representation of a GUID
     */
    public function encodeBinary(UuidInterface $uuid): string
    {
        $components = array_values($uuid->getFieldsHex());

        return (string) hex2bin(implode('', $components));
    }

    /**
     * Returns a GUID derived from a hexadecimal string representation
     *
     * @param string $encodedUuid
     * @return UuidInterface
     * @throws InvalidUuidStringException
     */
    public function decode(string $encodedUuid): UuidInterface
    {
        $components = $this->extractComponents($encodedUuid);

        $this->swapFields($components);

        return $this->getBuilder()->build($this, $this->getFields($components));
    }

    /**
     * Returns a GUID derived from a binary string representation
     *
     * @param string $bytes
     * @return UuidInterface
     * @throws InvalidArgumentException if $bytes is an invalid length
     */
    public function decodeBytes(string $bytes): UuidInterface
    {
        // Specifically call parent::decode to preserve correct byte order
        return parent::decode(bin2hex($bytes));
    }

    /**
     * Swap fields to support GUID byte order
     *
     * @param array $components An array of UUID components (the UUID exploded on its dashes)
     * @return void
     */
    private function swapFields(array &$components): void
    {
        $hex = unpack('H*', pack('L', hexdec($components[0])));
        $components[0] = $hex[1];

        $hex = unpack('H*', pack('S', hexdec($components[1])));
        $components[1] = $hex[1];

        $hex = unpack('H*', pack('S', hexdec($components[2])));
        $components[2] = $hex[1];
    }
}
