<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/22/16
 * Time: 5:08 PM
 */

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

$store = Mage::getModel('core/store')->load('wholesale', 'code');
Mage::getConfig()->saveConfig('customer/address/taxvat_show', 'opt', 'default', 0);
Mage::getConfig()->saveConfig('customer/address/taxvat_show', 'req', 'stores', $store->getId());

$installer->endSetup();
