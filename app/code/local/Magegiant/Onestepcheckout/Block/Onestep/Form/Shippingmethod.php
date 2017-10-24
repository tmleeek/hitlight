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
class Magegiant_Onestepcheckout_Block_Onestep_Form_Shippingmethod extends Mage_Checkout_Block_Onepage_Abstract
{
    protected $_rates;
    protected $_address;

    public function getShippingRates()
    {
        if (empty($this->_rates)) {
            $this->getAddress()->collectShippingRates()->save();
            $groups = $this->getAddress()->getGroupedAllShippingRates();

            return $this->_rates = $groups;
        }

        return $this->_rates;
    }

    public function getAddress()
    {
        if (empty($this->_address)) {
            $this->_address = $this->getQuote()->getShippingAddress();
        }

        return $this->_address;
    }

    public function getCarrierName($carrierCode)
    {
        if ($name = Mage::getStoreConfig('carriers/' . $carrierCode . '/title')) {
            return $name;
        }

        return $carrierCode;
    }

    /**
     * Check is Quote items can ship to
     *
     * @return boolean
     */
    public function canShip()
    {
        return !$this->getQuote()->isVirtual();
    }

    public function getAddressShippingMethod()
    {
        return $this->getAddress()->getShippingMethod();
    }

    public function getDefaultShippingMethod()
    {
        return Mage::helper('onestepcheckout/config')->getDefaultShippingMethod();
    }

    public function getShippingPrice($price, $flag)
    {
        return $this->getQuote()->getStore()->convertPrice(Mage::helper('tax')->getShippingPrice($price, $flag, $this->getAddress()), true);
    }

    public function getSaveShipmentUrl()
    {
        return Mage::getUrl('onestepcheckout/ajax/saveShippingMethod');
    }

    /**
     * get installed Store Pickup
     *
     * @return bool
     */
    public function isEnabledStorePickup()
    {
        return (Mage::helper('onestepcheckout')->isModuleEnabled('Magegiant_Storepickup')
            && Mage::helper('storepickup')->isEnabled());
    }

    /**
     * Enterprise Gitf Wrapping
     *
     * @return string
     */
    public function getEnterpriseGiftWrappingHtml()
    {
        if (Mage::helper('core')->isModuleEnabled('Enterprise_GiftWrapping')) {
            $giftWrapHtml = Mage::app()->getLayout()
                ->createBlock('enterprise_giftwrapping/checkout_options')
                ->setTemplate('giftwrapping/checkout/options.phtml')
                ->toHtml();
            $giftWrapHtml .= Mage::app()->getLayout()
                ->createBlock('onestepcheckout/onestep_form_shipping_enterprise_giftwrap')
                ->setTemplate('magegiant/onestepcheckout/onestep/form/shipping/enterprise/giftwrap.phtml')
                ->toHtml();

            return $giftWrapHtml;
        }

        return '';
    }
}