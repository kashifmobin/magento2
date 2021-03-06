<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */

namespace Magento\GroupedProduct\Test\Block\Adminhtml\Product\Grouped\AssociatedProducts;

use Mtf\Block\Form;
use Mtf\Client\Element;
use Mtf\Client\Element\Locator;

/**
 * Class ListAssociatedProducts
 * List associated products on the page
 */
class ListAssociatedProducts extends Form
{
    /**
     * Selector with item product
     *
     * @var string
     */
    protected $itemProduct = '//tr[@data-role="row"][@class="pointer"][%d]';

    /**
     * Getting block products
     *
     * @param string $index
     * @return ListAssociatedProducts\Product
     */
    private function getProductBlock($index)
    {
        $className = 'Magento\GroupedProduct\Test\Block\Adminhtml\Product\\' .
            'Grouped\AssociatedProducts\ListAssociatedProducts\Product';
        return $this->blockFactory->create(
            $className,
            ['element' => $this->_rootElement->find(sprintf($this->itemProduct, $index), Locator::SELECTOR_XPATH)]
        );
    }

    /**
     * Filling options products
     *
     * @param array $data
     * @param int $index
     * @return void
     */
    public function fillProductOptions(array $data, $index)
    {
        $this->getProductBlock($index)->fillOption($data);
    }

    /**
     * Get options products
     *
     * @param array $data
     * @param int $index
     * @return array
     */
    public function getProductOptions(array $data, $index)
    {
        return $this->getProductBlock($index)->getOption($data);
    }
}
