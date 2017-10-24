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
 * @category   Magegiant
 * @package    Magegiant_Onestepcheckout
 * @version    3.0.0
 * @copyright   Copyright (c) 2012 Magegiant (http://www.magegiant.com/)
 * @license     http://www.magegiant.com/license-agreement.html
 */


class Magegiant_Onestepcheckout_Block_Onestep extends Mage_Checkout_Block_Onepage_Abstract
{
    //protected $oHidePriceHelper;

    public function getGrandTotal()
    {
        return Mage::helper('onestepcheckout')->getGrandTotal($this->getQuote());
    }

    public function getPlaceOrderUrl()
    {
        return Mage::getUrl('onestepcheckout/ajax/placeOrder', array('_secure'=>true));
    }

    public function getBlockMap()
    {
        $updater = Mage::getModel('onestepcheckout/updater');
        $result = array();
        foreach($updater->getMap() as $action => $blocks) {
            $result[$action] = array_keys($blocks);
        }
        return $result;
    }

    public function chooseTemplate()
    {
        //$this->oHidePriceHelper = Mage::helper('cyberhideprice');
        $itemsCount = $this->getItemsCount() ? $this->getItemsCount() : $this->getQuote()->getItemsCount();
        //if ($itemsCount && $this->oHidePriceHelper->isAllow() === true) {
        if ($itemsCount) {
            $this->setTemplate($this->getHasItemTemplate());
        } else {
            $this->setTemplate($this->getEmptyTemplate());
        }
    }
}