<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/29/16
 * Time: 2:31 PM
 */

/* @var $installer Mage_Catalog_Model_Resource_Setup */

$installer = $this;
$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('cms/block'), 'use_instruction', 'TINYINT(1) NOT NULL default 0');

$installer->endSetup();
