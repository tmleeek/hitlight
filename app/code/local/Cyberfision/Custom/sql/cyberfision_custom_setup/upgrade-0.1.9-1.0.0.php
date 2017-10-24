<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/22/16
 * Time: 9:24 AM
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

Mage::getConfig()->saveConfig('amconf/general/hide_dropdowns', 1, 'default', 0);
Mage::getConfig()->saveConfig('amconf/general/show_clear', 1, 'default', 0);
Mage::getConfig()->saveConfig('amconf/general/oneselect_reload', 0, 'default', 0);
Mage::getConfig()->saveConfig('amconf/general/auto_select_attribute', 1, 'default', 0);
Mage::getConfig()->saveConfig('amconf/general/out_of_stock', 1, 'default', 0);

Mage::getConfig()->saveConfig('amconf/list/enable_list', 0, 'default', 0);
Mage::getConfig()->saveConfig('amconf/list/main_image_list_size_x', '360', 'default', 0);
Mage::getConfig()->saveConfig('amconf/list/main_image_list_size_y', '360', 'default', 0);

Mage::getConfig()->saveConfig('amconf/size/thumb', '72', 'default', 0);
Mage::getConfig()->saveConfig('amconf/size/preview_width', '780', 'default', 0);
Mage::getConfig()->saveConfig('amconf/size/preview_height', '780', 'default', 0);

Mage::getConfig()->saveConfig('amconf/zoom/enable', 0, 'default', 0);
Mage::getConfig()->saveConfig('amconf/zoom/type', 'window', 'default', 0);
Mage::getConfig()->saveConfig('amconf/zoom/change_main_img_with', 0, 'default', 0);

Mage::getConfig()->saveConfig('amconf/zoom_settings/viewer_width', '300', 'default', 0);
Mage::getConfig()->saveConfig('amconf/zoom_settings/viewer_height', '300', 'default', 0);
Mage::getConfig()->saveConfig('amconf/zoom_settings/preloading', 1, 'default', 0);
Mage::getConfig()->saveConfig('amconf/zoom_settings/fadein', 0, 'default', 0);
Mage::getConfig()->saveConfig('amconf/zoom_settings/easing', 0, 'default', 0);
Mage::getConfig()->saveConfig('amconf/zoom_settings/scroll', 0, 'default', 0);
Mage::getConfig()->saveConfig('amconf/zoom_settings/use_tint_effect', 0, 'default', 0);

Mage::getConfig()->saveConfig('amconf/lightbox/enable', 1, 'default', 0);
Mage::getConfig()->saveConfig('amconf/lightbox/thumbnail_lignhtbox', 1, 'default', 0);
Mage::getConfig()->saveConfig('amconf/lightbox/circular_lightbox', 1, 'default', 0);
Mage::getConfig()->saveConfig('amconf/lightbox/title_position', 'float', 'default', 0);
Mage::getConfig()->saveConfig('amconf/lightbox/thumbnail_helper', 1, 'default', 0);

Mage::getConfig()->saveConfig('amconf/carousel/enable', 1, 'default', 0);
Mage::getConfig()->saveConfig('amconf/carousel/visible_items', 5, 'default', 0);
Mage::getConfig()->saveConfig('amconf/carousel/circular', 1, 'default', 0);
Mage::getConfig()->saveConfig('amconf/carousel/swipe', 1, 'default', 0);
Mage::getConfig()->saveConfig('amconf/carousel/pagination', 0, 'default', 0);
Mage::getConfig()->saveConfig('amconf/carousel/auto', 0, 'default', 0);

$installer->endSetup();
