<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/15/16
 * Time: 11:18 AM
 */

$installer = $this;
$this->startSetup();

$this->addAttribute('catalog_category', 'home_order',  array(
    'type'     => 'int',
    'label'    => 'Order Number',
    'input'    => 'text',
    'user_defined'      => 1,
    'default'           => 0,
    'visible' => 0,
    'backend' => '',
    'required' => 0,
    'visible_on_front' => 1,
    'wysiwyg_enabled' => 1,
    'is_html_allowed_on_front'	=> 1,
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'group' => 'Home Browser All Products'
));


$this->endSetup();
