<?php
/**
 * GhoSter Avatar Customer Installer
 *
 * @category    GhoSter
 * @package     GhoSter_Avatar
 * @author      opensource
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$setup = Mage::getModel('customer/entity_setup', 'core_setup');
$customerEntityType = $setup->getEntityTypeId('customer');

$attributeCode = GhoSter_Avatar_Model_Config::AVATAR_ATTR_CODE;

#Remove if already installed
$setup->removeAttribute($customerEntityType, $attributeCode);

#add new attribute to customer entity
$setup->addAttribute(
    $customerEntityType,
    $attributeCode,
    array(
        'type' => 'varchar',
        'input' => 'image',
        'label' => 'Upload Avatar',
        'global' => 1,
        'visible' => 1,
        'required' => 0,
        'user_defined' => 1,
        'visible_on_front' => 1,
    )
);

if (version_compare(Mage::getVersion(), '1.6.0', '<=')) {
    $customer = Mage::getModel('customer/customer');
    $attrSetId = $customer->getResource()->getEntityType()->getDefaultAttributeSetId();
    $setup->addAttributeToSet($customerEntityType, $attrSetId, 'General', $attributeCode);
}
if (version_compare(Mage::getVersion(), '1.4.2', '>=')) {
    Mage::getSingleton('eav/config')
        ->getAttribute($customerEntityType, $attributeCode)
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
