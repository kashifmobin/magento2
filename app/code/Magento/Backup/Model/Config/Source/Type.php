<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */
namespace Magento\Backup\Model\Config\Source;

/**
 * Backups types' source model for system configuration
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Type implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Backup data
     *
     * @var \Magento\Backup\Helper\Data
     */
    protected $_backupData = null;

    /**
     * @param \Magento\Backup\Helper\Data $backupData
     */
    public function __construct(\Magento\Backup\Helper\Data $backupData)
    {
        $this->_backupData = $backupData;
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        $backupTypes = [];
        foreach ($this->_backupData->getBackupTypes() as $type => $label) {
            $backupTypes[] = ['label' => $label, 'value' => $type];
        }
        return $backupTypes;
    }
}
