<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */

namespace Magento\Backend\Test\Block;

use Mtf\Client\Element\Locator;

/**
 * Class FormPageActions
 * Form page actions block
 *
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
class FormPageActions extends PageActions
{
    /**
     * "Back" button
     *
     * @var string
     */
    protected $backButton = '#back';

    /**
     * "Reset" button
     *
     * @var string
     */
    protected $resetButton = '#reset';

    /**
     * "Save and Continue Edit" button
     *
     * @var string
     */
    protected $saveAndContinueButton = '#save_and_continue';

    /**
     * "Save" button
     *
     * @var string
     */
    protected $saveButton = '#save';

    /**
     * "Delete" button
     *
     * @var string
     */
    protected $deleteButton = '#delete';

    /**
     * Magento loader
     *
     * @var string
     */
    protected $loader = '//ancestor::body/div[@data-role="loader"]';

    /**
     * Magento varienLoader.js loader
     *
     * @var string
     */
    protected $loaderOld = '//ancestor::body/div[@id="loading-mask"]';

    /**
     * Click on "Back" button
     */
    public function back()
    {
        $this->_rootElement->find($this->backButton)->click();
    }

    /**
     * Click on "Reset" button
     */
    public function reset()
    {
        $this->waitBeforeClick();
        $this->_rootElement->find($this->resetButton)->click();
    }

    /**
     * Click on "Save and Continue Edit" button
     */
    public function saveAndContinue()
    {
        $this->waitBeforeClick();
        $this->_rootElement->find($this->saveAndContinueButton)->click();
        $this->waitForElementNotVisible('.popup popup-loading');
        $this->waitForElementNotVisible('.loader');
    }

    /**
     * Click on "Save" button
     */
    public function save()
    {
        $this->waitBeforeClick();
        $this->_rootElement->find($this->saveButton)->click();
        $this->waitForElementNotVisible($this->loader, Locator::SELECTOR_XPATH);
        $this->waitForElementNotVisible($this->loaderOld, Locator::SELECTOR_XPATH);
    }

    /**
     * Click on "Delete" button
     */
    public function delete()
    {
        $this->_rootElement->find($this->deleteButton)->click();
        $this->_rootElement->acceptAlert();
    }

    /**
     * Check 'Delete' button availability
     *
     * @return bool
     */
    public function checkDeleteButton()
    {
        return $this->_rootElement->find($this->deleteButton)->isVisible();
    }

    /**
     * Wait for User before click on any Button which calls JS validation on correspondent form.
     * See details in MAGETWO-31121.
     *
     * @return void
     */
    protected function waitBeforeClick()
    {
        usleep(500000);
    }
}
