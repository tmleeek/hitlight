<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/19/16
 * Time: 9:11 AM
 */

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();
$installer->getConnection()
    ->changeColumn($installer->getTable('ghoster_shopbyproject/product'), 'product_ids', 'product_skus', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable' => true,

    ));
$installer->endSetup();
