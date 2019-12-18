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

namespace Ramsey\Uuid\Provider\Node;

use Ramsey\Uuid\Provider\NodeProviderInterface;

/**
 * FallbackNodeProvider retrieves the system node ID by stepping through a list
 * of providers until a node ID can be obtained
 */
class FallbackNodeProvider implements NodeProviderInterface
{
    /**
     * @var NodeProviderInterface[]
     */
    private $nodeProviders;

    /**
     * Constructs a FallbackNodeProvider
     *
     * @param NodeProviderInterface[] $providers Array of node providers
     */
    public function __construct(array $providers)
    {
        $this->nodeProviders = $providers;
    }

    /**
     * Returns the system node ID
     *
     * @return string|null|false System node ID as a hexadecimal string
     */
    public function getNode()
    {
        foreach ($this->nodeProviders as $provider) {
            if ($node = $provider->getNode()) {
                return $node;
            }
        }

        return null;
    }
}
