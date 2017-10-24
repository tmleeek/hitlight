<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/22/16
 * Time: 5:08 PM
 */

$installer = new Mage_Eav_Model_Entity_Setup($this->_resourceName);
$installer->startSetup();

$installer->updateAttribute('catalog_product','attribute_group_is_tab','frontend_input', 'multiselect');
$installer->updateAttribute('catalog_product','attribute_group_is_tab','backend_model', 'eav/entity_attribute_backend_array');

$installer->endSetup();