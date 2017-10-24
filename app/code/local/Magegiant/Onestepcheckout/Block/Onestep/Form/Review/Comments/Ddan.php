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


class Magegiant_Onestepcheckout_Block_Onestep_Form_Review_Comments_Ddan extends Mage_Core_Block_Template
{
    public function getCalendarHtml()
    {
        if ($this->isDDANInstalled()) {
            $block = $this->getLayout()->createBlock('deliverydate/frontend_checkout_onepage_deliverydate');
            Mage::getSingleton('customer/session')->setGiantDeliverydateDate($this->getDeliveryDate());
            return $block->getCalendarHtml();
        }
        return '';
    }

    public function isDDANInstalled()
    {
        if (!Mage::helper('core')->isModuleEnabled('Magegiant_Deliverydate')) {
            return false;
        }
        return true;
    }

    public function getDeliveryDate()
    {
        $data = Mage::getSingleton('checkout/session')->getData('onestepcheckout_form_values');
        if (isset($data['giant_deliverydate_date'])) {
            return $data['giant_deliverydate_date'];
        }
        return '';
    }

    public function getComments()
    {
        $data = Mage::getSingleton('checkout/session')->getData('onestepcheckout_form_values');
        if (isset($data['comments'])) {
            return $data['comments'];
        }
        return null;
    }

    public function isGeneralNoticeEnabled()
    {
        return Mage::getStoreConfig(Magegiant_Deliverydate_Helper_Config::XML_PATH_GENERAL_NOTICE_ENABLED);
    }

    public function isTimeNoticeEnabled()
    {
        return Mage::getStoreConfig(Magegiant_Deliverydate_Helper_Config::XML_PATH_GENERAL_TIME_NOTICE_ENABLED);
    }

    /**
     * copy-paste from ddan
     *
     * @return string
     */
    public function getFormattedTime()
    {
        $Date = Mage::app()->getLocale()->date();
        $time = array('hour' => null, 'minute' => null, 'second' => null);
        $maxSameDay = Mage::getStoreConfig(Magegiant_Deliverydate_Helper_Config::XML_PATH_GENERAL_MAX_SAMEDAY_TIME);
        list($time['hour'], $time['minute'], $time['second']) = explode(",", $maxSameDay);
        $Date->setTime($time);
        return $this->formatTime($Date);
    }
}