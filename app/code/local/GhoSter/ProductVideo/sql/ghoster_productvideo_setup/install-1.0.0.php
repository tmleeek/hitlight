<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/27/16
 * Time: 3:05 PM
 */ 
/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();


$this->addAttribute('catalog_product', 'video_url', array(
    'input' => 'text',
    'type' => 'text',
    'label' => 'Product Video Url',
    'note' => 'Product Video Url',
    'backend' => '',
    'frontend' => '',
    'visible' => true,
    'required' => false,
    'visible_on_front' => true,
    'user_defined' => true,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_in_advanced_search' => false,
    'is_filterable_in_search' => false,
    'is_html_allowed_on_front' => true,
    'used_in_product_listing' => false,
    'used_for_sort_by' => false,
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL
));

$installer->endSetup();

$installer->endSetup();
