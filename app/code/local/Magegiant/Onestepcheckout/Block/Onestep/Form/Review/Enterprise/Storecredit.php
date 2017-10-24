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

class Magegiant_Onestepcheckout_Block_Onestep_Form_Review_Enterprise_Storecredit extends Mage_Checkout_Block_Onepage_Abstract
{
    public function canShow()
    {
        if (Mage::helper('onestepcheckout/enterprise_storecredit')->isStoreCreditEnabled()) {
            return true;
        }
        return false;
    }

    public function isStoreCreditSectionAvailable()
    {
        return Mage::helper('onestepcheckout/enterprise_storecredit')->isStoreCreditSectionAvailable();
    }

    public function getBalance()
    {
        return Mage::helper('onestepcheckout/enterprise_storecredit')->getBalance();
    }

    public function isCustomerBalanceUsed()
    {
        return Mage::helper('onestepcheckout/enterprise_storecredit')->isCustomerBalanceUsed();
    }

    public function formatPrice($value)
    {
        return Mage::getSingleton('adminhtml/session_quote')->getStore()->formatPrice($value);
    }

    public function getApplyStorecreditAjaxUrl()
    {
        return Mage::getUrl('onestepcheckout/ajax/applyEnterpriseStorecredit', array('_secure' => true));
    }
}