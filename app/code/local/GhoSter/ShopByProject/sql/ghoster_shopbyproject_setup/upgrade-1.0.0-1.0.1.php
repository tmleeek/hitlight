<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/6/16
 * Time: 9:00 AM
 */

/* @var $installer Mage_Catalog_Model_Resource_Setup */

$installer = $this;
$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('ghoster_shopbyproject/project'), 'project_image', 'VARCHAR(300) NOT NULL default ""');

$installer->endSetup();
