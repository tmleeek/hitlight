<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/26/16
 * Time: 5:59 PM
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

Mage::getConfig()->saveConfig('rss/config/active', 0, 'default', 0);

$installer->endSetup();
