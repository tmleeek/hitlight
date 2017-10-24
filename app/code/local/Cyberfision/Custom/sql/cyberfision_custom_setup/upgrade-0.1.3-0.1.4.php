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

$confirmContent = '
<p style="margin: 0;">You\'ve just added this product to the cart:</p>
<p style="color: green;margin: 0;"><b>{{var product.name}}</b></p>
<div>{{block type="ajaxcartpro/confirmation_items_productimage" product="$product" resize="135" }}</div>
{{block type="ajaxcartpro/confirmation_items_continue"}}
or
{{block type="ajaxcartpro/confirmation_items_gotocheckout"}}
';


Mage::getConfig()->saveConfig('ajaxcartpro/addproductconfirmation/content', $confirmContent, 'default', 0);
Mage::getConfig()->saveConfig('general/store_information/address', '8000 Innovation Park Dr.</br>Baton Rouge, LA 70820', 'default', 0);

$blocks = array('ajaxcartpro/confirmation_items_continue','ajaxcartpro/confirmation_items_gotocheckout','ajaxcartpro/confirmation_items_productimage');
foreach ($blocks as $block){
    $id = 0;
    $model = Mage::getModel('admin/block')->load($id);
    $datainsert = array();
    $datainsert['block_name'] = $block;
    $datainsert['is_allowed'] = 1;
    $model->setData($datainsert)->save();
}

$installer->endSetup();
