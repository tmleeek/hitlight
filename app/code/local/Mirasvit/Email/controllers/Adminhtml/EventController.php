<?php
/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at http://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   Trigger Email Suite
 * @version   1.0.1
 * @revision  156
 * @copyright Copyright (C) 2014 Mirasvit (http://mirasvit.com/)
 */


class Mirasvit_Email_Adminhtml_EventController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('email')
            ->_title(__('Trigger Email Suite'), __('Trigger Email Suite'))
            ->_title(__('Event Log'), __('Event Log'));

        return $this;
    }

    public function indexAction()
    {
        $this->_title($this->__('Mail Log'));
        $this->_initAction();
        $this->_addContent($this->getLayout()->createBlock('email/adminhtml_event'));
        $this->renderLayout();
    }
}