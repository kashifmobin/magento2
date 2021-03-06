<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */
$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
/** @var \Magento\Eav\Model\Entity\Attribute\Set $attributeSet */
$attributeSet = $objectManager->create('Magento\Eav\Model\Entity\Attribute\Set');
$entityTypeId = $objectManager->create('Magento\Eav\Model\Entity\Type')->loadByCode('catalog_product')->getId();
$attributeSet->setData([
    'attribute_set_name' => 'empty_attribute_set',
    'entity_type_id' => $entityTypeId,
    'sort_order' => 200,
]);
$attributeSet->validate();
$attributeSet->save();
