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


class Magegiant_Onestepcheckout_Block_Onestep_Form_Review_Referafriend extends Mage_Checkout_Block_Onepage_Abstract
{
    public function canShow()
    {
        if (Mage::helper('onestepcheckout/referafriend')->isReferafriendEnabled()) {
            return true;
        }
        return false;
    }

    public function isDiscountSectionAvailable()
    {
        return Mage::helper('onestepcheckout/referafriend')->isDiscountSectionAvailable();
    }

    public function getReservedAmount()
    {
        return Mage::helper('onestepcheckout/referafriend')->getReservedAmount();
    }

    public function getAppliedAmount()
    {
        return Mage::helper('onestepcheckout/referafriend')->getAppliedAmount();
    }

    public function getAvailableAmount($toPrice = false)
    {
        return Mage::helper('onestepcheckout/referafriend')->getAvailableAmount($toPrice);
    }

    public function getNumericAmount()
    {
        return Mage::helper('onestepcheckout/referafriend')->getNumericAmount();
    }

    public function getMaxDiscountPercent()
    {
        return Mage::helper('onestepcheckout/referafriend')->getMaxDiscountPercent();
    }

    public function getMaxDiscount($toPrice = false)
    {
        return Mage::helper('onestepcheckout/referafriend')->getMaxDiscount($toPrice);
    }
}