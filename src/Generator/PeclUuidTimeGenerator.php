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

namespace Ramsey\Uuid\Generator;

use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

/**
 * PeclUuidTimeGenerator generates strings of binary data for time-base UUIDs,
 * using ext-uuid
 *
 * @link https://pecl.php.net/package/uuid ext-uuid
 */
class PeclUuidTimeGenerator implements TimeGeneratorInterface
{
    /**
     * Generate a time-based binary string, using ext-uuid
     *
     * @param int|string $node Not used in this context
     * @param int $clockSeq Not used in this context
     * @return string A binary string
     * @throws UnsatisfiedDependencyException if a dependency is not present for
     *     the chosen generator
     */
    public function generate($node = null, int $clockSeq = null): string
    {
        $uuid = uuid_create(UUID_TYPE_TIME);

        return uuid_parse($uuid);
    }
}
