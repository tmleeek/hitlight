<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/22/16
 * Time: 5:08 PM
 */

$installer = new Mage_Eav_Model_Entity_Setup($this->_resourceName);
$installer->startSetup();

$installer->run("
    DELETE FROM {$installer->getTable('catalog_product_entity_varchar')} WHERE `attribute_id` = 408
");

$installer->endSetup();