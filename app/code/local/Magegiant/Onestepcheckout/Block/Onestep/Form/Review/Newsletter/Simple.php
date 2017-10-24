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
class Magegiant_Onestepcheckout_Block_Onestep_Form_Review_Newsletter_Simple extends Mage_Core_Block_Template
{
    protected $_customer = null;
    protected $_subscriptionObject = null;

    public function canShow()
    {
        if (!Mage::helper('onestepcheckout/newsletter')->isMageNewsletterEnabled()) {
            return false;
        }
        if ($this->isSubscribed()) {
            return false;
        }

        return true;
    }

    public function getCustomer()
    {
        if (is_null($this->_customer)) {
            $this->_customer = Mage::getSingleton('customer/session')->getCustomer();
        }

        return $this->_customer;
    }

    public function getSubscriptionObject()
    {
        if (is_null($this->_subscriptionObject)) {
            $this->_subscriptionObject = Mage::getModel('newsletter/subscriber');
            if ($this->getCustomer()->getId()) {
                $this->_subscriptionObject->loadByCustomer($this->getCustomer());
            }
        }

        return $this->_subscriptionObject;
    }

    public function isSubscribed()
    {
        if (!is_null($this->getSubscriptionObject())) {
            return $this->getSubscriptionObject()->isSubscribed();
        }

        return false;
    }

    public function getIsSubscribed()
    {
        $data       = Mage::getSingleton('checkout/session')->getData('onestepcheckout_form_values');
        $is_checked = false;
        if (isset($data['is_subscribed'])) {
            $is_checked = $data['is_subscribed'] ? true : false;
        } else {
            $is_checked = (bool)Mage::helper('onestepcheckout/config')->getDisplayConfig('is_checked_newsletter');
        }
        return $is_checked;
    }

    public function getSaveFormValuesUrl()
    {
        return Mage::getUrl('onestepcheckout/ajax/saveFormValues');
    }
}