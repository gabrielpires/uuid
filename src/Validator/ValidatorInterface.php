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

/**
 * A validator validates a string as a proper UUID
 */
interface ValidatorInterface
{
    /**
     * Returns true if the provided string represents a UUID
     *
     * @param string $uuid
     * @return bool
     */
    public function validate(string $uuid): bool;
}
