<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */
namespace Magento\Framework\DB;

/**
 * Class QueryFactory
 */
class QueryFactory
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Create Query object
     *
     * @param string $className
     * @param array $arguments
     * @return QueryInterface
     * @throws \Magento\Framework\Exception
     */
    public function create($className, array $arguments = [])
    {
        $query = $this->objectManager->create($className, $arguments);
        if (!$query instanceof QueryInterface) {
            throw new \Magento\Framework\Exception($className . ' doesn\'t implement \Magento\Framework\DB\QueryInterface');
        }
        return $query;
    }
}
