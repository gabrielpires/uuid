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

namespace Ramsey\Uuid\Validator;

use Ramsey\Uuid\Uuid;

/**
 * Validator validates strings as UUIDs of any variant
 */
class Validator implements ValidatorInterface
{
    /**
     * Regular expression pattern for matching a UUID of any variant.
     */
    public const VALID_PATTERN = '^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$';

    /**
     * Returns true if the provided string represents a UUID
     *
     * @param string $uuid
     * @return bool
     */
    public function validate($uuid): bool
    {
        $uuid = str_replace(['urn:', 'uuid:', '{', '}'], '', $uuid);

        return $uuid === Uuid::NIL || preg_match('/' . self::VALID_PATTERN . '/D', $uuid);
    }
}
