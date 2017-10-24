<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/26/16
 * Time: 5:59 PM
 */

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

$setup = Mage::getResourceModel('catalog/setup','catalog_setup');
$setup->removeAttribute('catalog_product','gift_template_ids');
$setup->removeAttribute('catalog_product','gift_type');
$setup->removeAttribute('catalog_product','gift_price_type');

$installer->endSetup();
