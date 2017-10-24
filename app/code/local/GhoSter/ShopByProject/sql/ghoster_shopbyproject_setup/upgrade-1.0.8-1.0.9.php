<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/29/16
 * Time: 1:30 PM
 */

/* @var $installer Mage_Catalog_Model_Resource_Setup */

$installer = $this;
$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('ghoster_shopbyproject/category'), 'summary', 'TEXT NULL');

$installer->endSetup();
