<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/6/16
 * Time: 9:00 AM
 */

$installer = $this;
$this->startSetup();



$this->addAttribute('catalog_category', 'slider_params', array(
    'input' => 'text',
    'label'    => 'Catalog Slides',
    'type' => 'text',
    'backend' => '',
    'visible' => false,
    'required' => false,
    'visible_on_front' => true,
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE
));


$this->endSetup();
