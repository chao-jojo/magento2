<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Elasticsearch\Model\Layer\Search;

use Magento\Catalog\Model\Layer\ItemCollectionProviderInterface;
use Magento\Framework\Search\EngineResolverInterface;

/**
 * Catalog search category layer collection provider.
 */
class ItemCollectionProvider implements ItemCollectionProviderInterface
{
    /**
     * @var EngineResolverInterface
     */
    private $engineResolver;

    /**
     * @var array
     */
    private $factories;

    /**
     * ItemCollectionProvider constructor.
     * @param EngineResolverInterface $engineResolver
     * @param array $factories
     */
    public function __construct(
        EngineResolverInterface $engineResolver,
        array $factories
    ) {
        $this->engineResolver = $engineResolver;
        $this->factories = $factories;
    }

    /**
     * @param \Magento\Catalog\Model\Category $category
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getCollection(\Magento\Catalog\Model\Category $category)
    {
        if (!isset($this->factories[$this->engineResolver->getCurrentSearchEngine()])) {
            throw new \DomainException('Undefined factory ' . $this->engineResolver->getCurrentSearchEngine());
        }
        return $this->factories[$this->engineResolver->getCurrentSearchEngine()]->create();
    }
}
