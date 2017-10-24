<?php
/**
 * Magegiant
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magegiant.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magegiant.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Magegiant
 * @package     Magegiant_Onestepcheckout
 * @copyright   Copyright (c) 2012 Magegiant (http://www.magegiant.com/)
 * @license     http://www.magegiant.com/license-agreement.html
 */

/**
 * CustomerAttributes Edit Form Content Tab Block
 *
 * @category    Magegiant
 * @package     Magegiant_Onestepcheckout
 * @author      Magegiant Developer
 */
class Magegiant_Onestepcheckout_Block_Adminhtml_Customer_Formtype extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Block constructor
     *
     */
    public function __construct()
    {
        $this->_blockGroup = 'onestepcheckout';
        $this->_controller = 'adminhtml_customer_formtype';
        $this->_headerText = Mage::helper('onestepcheckout')->__('Manage Form Types');

        parent::__construct();

        $this->_updateButton('add', 'label', Mage::helper('onestepcheckout')->__('New Form Type'));
    }
}
