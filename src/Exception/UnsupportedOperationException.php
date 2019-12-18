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

namespace Ramsey\Uuid\Exception;

use RuntimeException;

/**
 * Thrown to indicate that the requested operation is not supported.
 */
class UnsupportedOperationException extends RuntimeException
{
}
