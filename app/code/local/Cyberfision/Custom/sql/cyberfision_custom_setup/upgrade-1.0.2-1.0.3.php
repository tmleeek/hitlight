<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/22/16
 * Time: 5:08 PM
 */

$installer = new Mage_Eav_Model_Entity_Setup($this->_resourceName);
$installer->startSetup();

$installer->addAttribute('catalog_product', 'attribute_group_is_tab', array(
    'type'              => 'varchar',
    'backend'           => '',
    'frontend'          => '',
    'label'             => 'Attribute is tab',
    'note'              => '',
    'input'             => 'select',
    'class'             => '',
    'source'            => 'cyberfision_custom/source_attribute',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'           => true,
    'required'          => false,
    'user_defined'      => true,
    'default'           => '',
    'searchable'        => false,
    'filterable'        => false,
    'comparable'        => false,
    'visible_on_front'  => false,
    'unique'            => false,
    'apply_to'          => 'grouped',
    'is_configurable'   => false
));

$attributeId = $installer->getAttributeId('catalog_product', 'attribute_group_is_tab');

foreach ($installer->getAllAttributeSetIds('catalog_product') as $attributeSetId)
{
    try {
        $attributeGroupId = $installer->getAttributeGroupId('catalog_product', $attributeSetId, 'General');
    } catch (Exception $e) {
        $attributeGroupId = $installer->getDefaultAttributeGroupId('catalog_product', $attributeSetId);
    }
    $installer->addAttributeToSet('catalog_product', $attributeSetId, $attributeGroupId, $attributeId);
}

$installer->endSetup();