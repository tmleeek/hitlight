<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/12/16
 * Time: 2:08 PM
 */

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

$store1 = Mage::getModel('core/store')->load('default', 'code');
$store2 = Mage::getModel('core/store')->load('wholesale', 'code');
$store1->setData('name','Residentials');
$store2->setData('name','Commercials');
$store1->save();
$store2->save();

Mage::getConfig()->saveConfig('design/theme/default', 'wholesale', 'stores', $store2->getId());

$installer->endSetup();
