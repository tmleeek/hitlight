<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/17/16
 * Time: 3:52 PM
 */
class GhoSter_SocialCount_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function getStoreConfig()
    {
        $config = [];

        $config['active'] = (Mage::getStoreConfig('social_share_count/general/active', Mage::app()->getStore()));
        $config['share_button'] = (Mage::getStoreConfig('social_share_count/general/enable_button', Mage::app()->getStore()));
        $config['facebook']['active'] = (Mage::getStoreConfig('social_share_count/facebook/enabled', Mage::app()->getStore()));
        $config['linkedin']['active'] = (Mage::getStoreConfig('social_share_count/linkedin/enabled', Mage::app()->getStore()));
        $config['pinterest']['active'] = (Mage::getStoreConfig('social_share_count/pinterest/enabled', Mage::app()->getStore()));
        $config['google']['active'] = (Mage::getStoreConfig('social_share_count/google/enabled', Mage::app()->getStore()));
        $config['twitter']['active'] = (Mage::getStoreConfig('social_share_count/twitter/enabled', Mage::app()->getStore()));

        return $config;
    }

    public static function log($message, $level = null, $file = '', $forceLog = false)
    {
        if (Mage::getIsDeveloperMode()) {
            Mage::log($message, $level, $file, $forceLog);
        }
    }
}
