<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */
namespace Magento\Catalog\Model\Indexer\Category\Product\Plugin;

class StoreGroupTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Indexer\Model\IndexerInterface
     */
    protected $indexerMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|
     */
    protected $pluginMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject;

    /**
     * @var \Magento\Indexer\Model\IndexerRegistry|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $indexerRegistryMock;

    /**
     * @var StoreView
     */
    protected $model;

    protected function setUp()
    {
        $this->indexerMock = $this->getMockForAbstractClass(
            'Magento\Indexer\Model\IndexerInterface',
            [],
            '',
            false,
            false,
            true,
            ['getId', 'getState', '__wakeup']
        );
        $this->subject = $this->getMock('Magento\Store\Model\Resource\Group', [], [], '', false);
        $this->indexerRegistryMock = $this->getMock('Magento\Indexer\Model\IndexerRegistry', ['get'], [], '', false);

        $this->model = new StoreGroup($this->indexerRegistryMock);
    }

    /**
     * @param array $valueMap
     * @dataProvider changedDataProvider
     */
    public function testAroundSave($valueMap)
    {
        $this->mockIndexerMethods();
        $groupMock = $this->getMock(
            'Magento\Store\Model\Group',
            ['dataHasChangedFor', 'isObjectNew', '__wakeup'],
            [],
            '',
            false
        );
        $groupMock->expects($this->exactly(2))->method('dataHasChangedFor')->will($this->returnValueMap($valueMap));
        $groupMock->expects($this->once())->method('isObjectNew')->will($this->returnValue(false));

        $proceed = $this->mockPluginProceed();
        $this->assertFalse($this->model->aroundSave($this->subject, $proceed, $groupMock));
    }

    /**
     * @param array $valueMap
     * @dataProvider changedDataProvider
     */
    public function testAroundSaveNotNew($valueMap)
    {
        $groupMock = $this->getMock(
            'Magento\Store\Model\Group',
            ['dataHasChangedFor', 'isObjectNew', '__wakeup'],
            [],
            '',
            false
        );
        $groupMock->expects($this->exactly(2))->method('dataHasChangedFor')->will($this->returnValueMap($valueMap));
        $groupMock->expects($this->once())->method('isObjectNew')->will($this->returnValue(true));

        $proceed = $this->mockPluginProceed();
        $this->assertFalse($this->model->aroundSave($this->subject, $proceed, $groupMock));
    }

    public function changedDataProvider()
    {
        return [
            [
                [['root_category_id', true], ['website_id', false]],
                [['root_category_id', false], ['website_id', true]],
            ]
        ];
    }

    public function testAroundSaveWithoutChanges()
    {
        $groupMock = $this->getMock(
            'Magento\Store\Model\Group',
            ['dataHasChangedFor', 'isObjectNew', '__wakeup'],
            [],
            '',
            false
        );
        $groupMock->expects(
            $this->exactly(2)
        )->method(
            'dataHasChangedFor'
        )->will(
            $this->returnValueMap([['root_category_id', false], ['website_id', false]])
        );
        $groupMock->expects($this->never())->method('isObjectNew');

        $proceed = $this->mockPluginProceed();
        $this->assertFalse($this->model->aroundSave($this->subject, $proceed, $groupMock));
    }

    protected function mockIndexerMethods()
    {
        $this->indexerMock->expects($this->once())->method('invalidate');
        $this->indexerRegistryMock->expects($this->once())
            ->method('get')
            ->with(\Magento\Catalog\Model\Indexer\Category\Product::INDEXER_ID)
            ->will($this->returnValue($this->indexerMock));
    }

    protected function mockPluginProceed($returnValue = false)
    {
        return function () use ($returnValue) {
            return $returnValue;
        };
    }
}
