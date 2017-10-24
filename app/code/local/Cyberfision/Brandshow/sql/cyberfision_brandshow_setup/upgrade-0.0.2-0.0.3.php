<?php
$installer = $this;

$installer->startSetup();

$installer->removeAttribute('catalog_product', 'example_field');


$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'child_sku_product', array(
    'group'             => 'Additional Data',
    'type'              => 'text',
    'backend'           => '',
    'input_renderer'    => NULL,
    'label'             => 'SKU child products',
    'class'             => '',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'           => true,
    'required'          => false,
    'user_defined'      => true,
    'is_searchable'     => true,
    'is_visible_in_advanced_search' => true,
    'filterable'        => false,
    'comparable'        => false,
    'visible_on_front'  => false,
    'unique'            => false,
    'apply_to'          => 'simple,configurable,bundle,grouped',
    //'is_configurable'   => false,
));

$installer->endSetup();