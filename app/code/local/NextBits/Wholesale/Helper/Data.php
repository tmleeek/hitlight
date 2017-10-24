<?php

class NextBits_Wholesale_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function getRegisterUrl()
    {
        return $this->_getUrl('wholesale/account/create');
    }

    public function getStoreConfig()
    {
        $config = [];

        $config['catalog']['title'] = (Mage::getStoreConfig('wholesale/catalog/bar_title', Mage::app()->getStore()));
        $config['catalog']['enable_phone'] = (Mage::getStoreConfig('wholesale/catalog/call_us', Mage::app()->getStore()));
        $config['catalog']['cms_page'] = (Mage::getStoreConfig('wholesale/catalog/learn_more', Mage::app()->getStore()));

        return $config;
    }

}