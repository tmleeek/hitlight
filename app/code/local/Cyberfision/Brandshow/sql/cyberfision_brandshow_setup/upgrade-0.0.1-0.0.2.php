<?php
$installer = $this;
$installer->startSetup();
// Remove Product Attribute
$installer->removeAttribute('catalog_product', 'brand_id');

$installer->endSetup();
?>