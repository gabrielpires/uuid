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

use InvalidArgumentException;
use Ramsey\Uuid\BinaryUtils;
use Ramsey\Uuid\Converter\TimeConverterInterface;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Provider\NodeProviderInterface;
use Ramsey\Uuid\Provider\TimeProviderInterface;

/**
 * DefaultTimeGenerator generates strings of binary data based on a node ID,
 * clock sequence, and the current time
 */
class DefaultTimeGenerator implements TimeGeneratorInterface
{
    /**
     * @var NodeProviderInterface
     */
    private $nodeProvider;

    /**
     * @var TimeConverterInterface
     */
    private $timeConverter;

    /**
     * @var TimeProviderInterface
     */
    private $timeProvider;

    /**
     * Constructs a DefaultTimeGenerator using a node provider, time converter,
     * and time provider
     *
     * @param NodeProviderInterface $nodeProvider
     * @param TimeConverterInterface $timeConverter
     * @param TimeProviderInterface $timeProvider
     */
    public function __construct(
        NodeProviderInterface $nodeProvider,
        TimeConverterInterface $timeConverter,
        TimeProviderInterface $timeProvider
    ) {
        $this->nodeProvider = $nodeProvider;
        $this->timeConverter = $timeConverter;
        $this->timeProvider = $timeProvider;
    }

    /**
     * Generate a binary string from a node ID, clock sequence, and current time
     *
     * If $node is not provided, we will attempt to obtain the local hardware
     * address. If $clockSeq is provided, it is used as the sequence number;
     * otherwise a random 14-bit sequence number is chosen.
     *
     * @param int|string $node A 48-bit number representing the hardware address;
     *     this number may be represented as an integer or a hexadecimal string
     * @param int $clockSeq A 14-bit number used to help avoid duplicates that
     *     could arise when the clock is set backwards in time or if the node ID
     *     changes
     * @return string A binary string
     * @throws UnsatisfiedDependencyException if a dependency is not present for
     *     the chosen generator
     * @throws InvalidArgumentException if the parameters contain invalid values
     */
    public function generate($node = null, int $clockSeq = null): string
    {
        $node = $this->getValidNode($node);

        if ($clockSeq === null) {
            // This does not use "stable storage"; see RFC 4122, Section 4.2.1.1.
            $clockSeq = random_int(0, 0x3fff);
        }

        // Create a 60-bit time value as a count of 100-nanosecond intervals
        // since 00:00:00.00, 15 October 1582.
        $timeOfDay = $this->timeProvider->currentTime();
        $uuidTime = $this->timeConverter->calculateTime(
            (string) ($timeOfDay['sec'] ?? ''),
            (string) ($timeOfDay['usec'] ?? '')
        );

        $timeHi = BinaryUtils::applyVersion((string) ($uuidTime['hi'] ?? 0), 1);
        $clockSeqHi = BinaryUtils::applyVariant($clockSeq >> 8);

        $hex = vsprintf(
            '%08s%04s%04s%02s%02s%012s',
            [
                $uuidTime['low'] ?? 0,
                $uuidTime['mid'] ?? 0,
                sprintf('%04x', $timeHi),
                sprintf('%02x', $clockSeqHi),
                sprintf('%02x', $clockSeq & 0xff),
                $node,
            ]
        );

        return (string) hex2bin($hex);
    }

    /**
     * Uses the node provider given when constructing this instance to get
     * the node ID (usually a MAC address)
     *
     * @param string|int|null $node A node value that may be used to override the node provider
     * @return string Hexadecimal representation of the node ID
     * @throws InvalidArgumentException
     */
    private function getValidNode($node): string
    {
        if ($node === null) {
            $node = $this->nodeProvider->getNode();
        }

        // Convert the node to hex, if it is still an integer.
        if (is_int($node)) {
            $node = sprintf('%012x', $node);
        }

        if (!ctype_xdigit((string) $node) || strlen((string) $node) > 12) {
            throw new InvalidArgumentException('Invalid node value');
        }

        return strtolower(sprintf('%012s', $node));
    }
}
