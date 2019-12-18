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

/**
 * Returns a version 1 (time-based) UUID from a host ID, sequence number,
 * and the current time
 *
 * @param int|string $node A 48-bit number representing the hardware address;
 *     this number may be represented as an integer or a hexadecimal string
 * @param int $clockSeq A 14-bit number used to help avoid duplicates that
 *     could arise when the clock is set backwards in time or if the node ID
 *     changes
 * @return string
 */
function v1($node = null, $clockSeq = null)
{
    return Uuid::uuid1($node, $clockSeq)->toString();
}

/**
 * Returns a version 3 (name-based) UUID based on the MD5 hash of a
 * namespace ID and a name
 *
 * @param string|UuidInterface $ns The namespace (must be a valid UUID)
 * @param string $name
 * @return string
 */
function v3($ns, $name)
{
    return Uuid::uuid3($ns, $name)->toString();
}

/**
 * Returns a version 4 (random) UUID
 *
 * @return string
 */
function v4()
{
    return Uuid::uuid4()->toString();
}

/**
 * Returns a version 5 (name-based) UUID based on the SHA-1 hash of a
 * namespace ID and a name
 *
 * @param string|UuidInterface $ns The namespace (must be a valid UUID)
 * @param string $name
 * @return string
 */
function v5($ns, $name)
{
    return Uuid::uuid5($ns, $name)->toString();
}
