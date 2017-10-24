<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/12/16
 * Time: 10:19 AM
 */

/* @var $installer Mage_Catalog_Model_Resource_Setup */

$installer = $this;
$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('ghoster_shopbyproject/project'), 'status', 'TINYINT(1) NOT NULL default 1');

$installer->endSetup();
