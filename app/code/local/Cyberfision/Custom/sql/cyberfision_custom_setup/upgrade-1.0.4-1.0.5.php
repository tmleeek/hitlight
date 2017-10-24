<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/22/16
 * Time: 5:08 PM
 */

$installer = new Mage_Eav_Model_Entity_Setup($this->_resourceName);
$installer->startSetup();

$installer->addAttribute('catalog_product', 'area_product_grouped', array(
    'type'              => 'int',
    'backend'           => '',
    'frontend'          => '',
    'label'             => 'Disable Area Products',
    'note'              => '',
    'input'             => 'select',
    'class'             => '',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'           => true,
    'required'          => false,
    'user_defined'      => true,
    'default'           => '',
    'searchable'        => false,
    'filterable'        => false,
    'comparable'        => false,
    'visible_on_front'  => false,
    'unique'            => false,
    'apply_to'          => 'grouped',
    'is_configurable'   => false,
    'group'             => 'General',
    'source'            => 'eav/entity_attribute_source_boolean'
));

$installer->endSetup();