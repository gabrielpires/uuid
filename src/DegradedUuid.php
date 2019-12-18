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

use DateTimeImmutable;
use DateTimeInterface;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Exception\UnsupportedOperationException;

/**
 * DegradedUuid represents an RFC 4122 UUID on 32-bit systems
 *
 * Some of the functionality of a DegradedUuid is not present or degraded, since
 * 32-bit systems are unable to perform the necessary mathematical operations or
 * represent the integers appropriately.
 */
class DegradedUuid extends Uuid
{
    /**
     * @inheritDoc
     *
     * @return DateTimeInterface A PHP DateTimeImmutable representation of the date
     * @throws UnsupportedOperationException if UUID is not time-based
     */
    public function getDateTime(): DateTimeInterface
    {
        if ($this->getVersion() != 1) {
            throw new UnsupportedOperationException('Not a time-based UUID');
        }

        $time = $this->numberConverter->fromHex($this->getTimestampHex());
        $unixTime = $this->timeConverter->convertTime($time);

        return new DateTimeImmutable("@{$unixTime}");
    }

    /**
     * @inheritDoc
     *
     * @return array
     * @throws UnsatisfiedDependencyException if called on a 32-bit system
     */
    public function getFields(): array
    {
        throw new UnsatisfiedDependencyException(
            'Cannot call ' . __METHOD__ . ' on a 32-bit system, since some '
            . 'values overflow the system max integer value'
            . '; consider calling getFieldsHex instead'
        );
    }

    /**
     * @inheritDoc
     *
     * @return int
     * @throws UnsatisfiedDependencyException if called on a 32-bit system
     */
    public function getNode(): int
    {
        throw new UnsatisfiedDependencyException(
            'Cannot call ' . __METHOD__ . ' on a 32-bit system, since node '
            . 'is an unsigned 48-bit integer and can overflow the system '
            . 'max integer value'
            . '; consider calling getNodeHex instead'
        );
    }

    /**
     * @inheritDoc
     *
     * @return int
     * @throws UnsatisfiedDependencyException if called on a 32-bit system
     */
    public function getTimeLow(): int
    {
        throw new UnsatisfiedDependencyException(
            'Cannot call ' . __METHOD__ . ' on a 32-bit system, since time_low '
            . 'is an unsigned 32-bit integer and can overflow the system '
            . 'max integer value'
            . '; consider calling getTimeLowHex instead'
        );
    }

    /**
     * @inheritDoc
     *
     * @return int
     * @throws UnsatisfiedDependencyException if called on a 32-bit system
     * @throws UnsupportedOperationException if UUID is not time-based
     */
    public function getTimestamp(): int
    {
        if ($this->getVersion() != 1) {
            throw new UnsupportedOperationException('Not a time-based UUID');
        }

        throw new UnsatisfiedDependencyException(
            'Cannot call ' . __METHOD__ . ' on a 32-bit system, since timestamp '
            . 'is an unsigned 60-bit integer and can overflow the system '
            . 'max integer value'
            . '; consider calling getTimestampHex instead'
        );
    }
}
