<?php

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$setup = Mage::getModel('customer/entity_setup', 'core_setup');
$attributeCode = GhoSter_Avatar_Model_Config::AVATAR_ATTR_CODE;

// add new attribute to customer entity
$setup->addAttribute(
        'customer', 
        $attributeCode, 
        array(
                'type'              => 'varchar',
                'input'             => 'file',
                'label'             => 'Upload Avatar',
                'global'            => 1,
                'visible'           => 1,
                'required'          => 0,
                'user_defined'      => 1,
                'visible_on_front'  => 1,
                'source'            => 'profile/entity_avatar',
         )
);

if (version_compare(Mage::getVersion(), '1.6.0', '<='))
{
      $customer = Mage::getModel('customer/customer');
      $attrSetId = $customer->getResource()->getEntityType()->getDefaultAttributeSetId();
      $setup->addAttributeToSet('customer', $attrSetId, 'General', $attributeCode);
}
if (version_compare(Mage::getVersion(), '1.4.2', '>='))
{
    Mage::getSingleton('eav/config')
    ->getAttribute('customer', $attributeCode)
    ->setData(
               'used_in_forms', 
                array(
                       'adminhtml_customer',
                       'customer_account_create',
                       'customer_account_edit',
                       'checkout_register'
                )
    )
    ->save();
}

$installer->endSetup(); 
