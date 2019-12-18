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
 * RandomBytesGenerator generates strings of random binary data using the
 * built-in `random_bytes()` PHP function
 *
 * @link http://php.net/random_bytes random_bytes()
 */
class RandomBytesGenerator implements RandomGeneratorInterface
{
    /**
     * Generates a string of randomized binary data
     *
     * @param int $length The number of bytes of random binary data to generate
     * @return string A binary string
     * @throws UnsatisfiedDependencyException if the chosen generator is not present
     */
    public function generate(int $length): string
    {
        return random_bytes($length);
    }
}
