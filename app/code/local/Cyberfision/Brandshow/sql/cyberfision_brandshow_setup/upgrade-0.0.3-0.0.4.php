<?php
$installer = $this;
$installer->startSetup();
// Remove Product Attribute video youtube
$installer->removeAttribute('catalog_product', 'youtubevidurl');

$installer->endSetup();
?>