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


class Magegiant_Onestepcheckout_Block_Onestep_Form_Address extends Mage_Checkout_Block_Onepage_Abstract
{
    public function allowShipToDifferent()
    {
        return $this->getConfig()->allowShipToDifferent();
    }

    public function getConfig()
    {
        return Mage::helper('onestepcheckout/config');
    }

    public function getAddressChangedUrl()
    {
        return Mage::getUrl('onestepcheckout/ajax/saveAddress');
    }

    public function canShip()
    {
        return !$this->getQuote()->isVirtual();
    }

    public function getSaveFormValuesUrl()
    {
        return Mage::getUrl('onestepcheckout/ajax/saveFormValues');
    }
}