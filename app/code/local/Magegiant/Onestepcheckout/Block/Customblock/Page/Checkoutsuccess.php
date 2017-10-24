<?php
/**
 * Magegiant
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the magegiant.com license that is
 * available through the world-wide-web at this URL:
 * http://magegiant.com/license-agreement/
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Magegiant
 * @package     Magegiant_Onestepcheckout
 * @copyright   Copyright (c) 2014 Magegiant (http://magegiant.com/)
 * @license     http://magegiant.com/license-agreement/
 */

/**
 *
 * @category    Magegiant
 * @package     Magegiant_Onestepcheckout
 * @author      Magegiant Developer
 */
class Magegiant_Onestepcheckout_Block_Customblock_Page_Checkoutsuccess extends Magegiant_Onestepcheckout_Block_Customblock_Abstract
{
    public function __construct()
    {
        $quoteId      = Mage::getSingleton('checkout/session')->getLastQuoteId();
        $this->_quote = Mage::getModel('sales/quote')->loadByIdWithoutStore($quoteId);
        parent::__construct();
    }
}