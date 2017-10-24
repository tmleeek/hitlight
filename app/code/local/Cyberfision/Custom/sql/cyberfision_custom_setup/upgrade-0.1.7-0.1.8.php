<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/12/16
 * Time: 11:49 AM
 */

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

//#addStoreView Wholesale
/** @var $store Mage_Core_Model_Store */
$store = Mage::getModel('core/store');
$storeGroup = Mage::getModel('core/store_group');
$store->setCode('wholesale')
    ->setWebsiteId(1)
    ->setGroupId(1)
    ->setName('Wholesale')
    ->setIsActive(1)
    ->save();

$installer->endSetup();
