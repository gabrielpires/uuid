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

namespace Ramsey\Uuid;

use Ramsey\Uuid\Validator\ValidatorInterface;

/**
 * UuidFactoryInterface defines common functionality all `UuidFactory` instances
 * must implement
 */
interface UuidFactoryInterface
{
    /**
     * Returns the validator to use for the factory
     *
     * @return ValidatorInterface
     */
    public function getValidator(): ValidatorInterface;

    /**
     * Returns a version 1 (time-based) UUID from a host ID, sequence number,
     * and the current time
     *
     * @param int|string $node A 48-bit number representing the hardware address;
     *     this number may be represented as an integer or a hexadecimal string
     * @param int $clockSeq A 14-bit number used to help avoid duplicates that
     *     could arise when the clock is set backwards in time or if the node ID
     *     changes
     * @return UuidInterface
     */
    public function uuid1($node = null, ?int $clockSeq = null): UuidInterface;

    /**
     * Returns a version 3 (name-based) UUID based on the MD5 hash of a
     * namespace ID and a name
     *
     * @param string|UuidInterface $ns The namespace (must be a valid UUID)
     * @param string $name
     * @return UuidInterface
     */
    public function uuid3($ns, string $name): UuidInterface;

    /**
     * Returns a version 4 (random) UUID
     *
     * @return UuidInterface
     */
    public function uuid4(): UuidInterface;

    /**
     * Returns a version 5 (name-based) UUID based on the SHA-1 hash of a
     * namespace ID and a name
     *
     * @param string|UuidInterface $ns The namespace (must be a valid UUID)
     * @param string $name
     * @return UuidInterface
     */
    public function uuid5($ns, string $name): UuidInterface;

    /**
     * Creates a UUID from a byte string
     *
     * @param string $bytes
     * @return UuidInterface
     */
    public function fromBytes(string $bytes): UuidInterface;

    /**
     * Creates a UUID from the string standard representation
     *
     * @param string $uuid
     * @return UuidInterface
     */
    public function fromString(string $uuid): UuidInterface;

    /**
     * Creates a UUID from a 128-bit integer string
     *
     * @param string $integer String representation of 128-bit integer
     * @return UuidInterface
     */
    public function fromInteger($integer): UuidInterface;
}
