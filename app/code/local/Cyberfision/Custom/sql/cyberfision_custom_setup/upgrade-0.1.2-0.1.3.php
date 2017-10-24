<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/26/16
 * Time: 5:59 PM
 */

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

Mage::getConfig()->saveConfig('general/store_information/name', 'HitLights LED', 'default', 0);
Mage::getConfig()->saveConfig('general/store_information/address', '8000 Innovation Park Dr.</br>Baton Rouge, LA 70820', 'default', 0);

$installer->endSetup();
