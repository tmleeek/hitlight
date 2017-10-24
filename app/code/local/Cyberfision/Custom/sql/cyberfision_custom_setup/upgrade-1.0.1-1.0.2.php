<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/22/16
 * Time: 5:08 PM
 */

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();
$attributes = array('led_stripadapter_color','ledstrip_white_color_temp','ledstrip_color','ledstripaccessory_ledcolor','ledbulb_white_color_temp','ledbulb_color','ledbulbnewcolor','color_temp','autoled_white_color_temp','autoled_color','color', 'ip_rating ', 'ledstrip_ip_rating', 'led_stripadapter_iprating', 'ledstripaccessory_leddensity', 'ledstrip_dimmable', 'ledstripaccessory_compatible', 'led_stripcontr_compatible', 'price' );
foreach ($attributes as $attrCode){
    $attrId = $installer->getAttributeId(Mage_Catalog_Model_Product::ENTITY, $attrCode);
    $this->updateAttribute(Mage_Catalog_Model_Product::ENTITY,$attrId, 'is_filterable', 1);
}

$installer->endSetup();
