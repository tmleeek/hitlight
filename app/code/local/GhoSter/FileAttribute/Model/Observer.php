<?php

/**
 * GhoSter FileAttribute Model Observer
 *
 * @category    GhoSter
 * @package     GhoSter_FileAttribute
 * @author      opensource
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class GhoSter_FileAttribute_Model_Observer
{
    /**
     * Add file upload input type to attribute creation dropdown
     *
     * @param Varien_Event_Observer $observer
     * @return $this
     */
    public function addFileAttributeType(Varien_Event_Observer $observer)
    {
        $response = $observer->getEvent()->getResponse();

        $types = $response->getTypes();
        $types[] = array(
            'value' => 'ghoster_file',
            'label' => Mage::helper('ghoster_fileattribute')->__('File Upload'),
            'hide_fields' => array(
                'is_unique',
                'is_required',
                'frontend_class',
                'is_configurable',
                '_default_value',

                'is_searchable',
                'is_visible_in_advanced_search',
                'is_filterable',
                'is_filterable_in_search',
                'is_comparable',
                'is_used_for_promo_rules',
                'position',
                'used_in_product_listing',
                'used_for_sort_by',
            )
        );

        $response->setTypes($types);

        return $this;
    }

    /**
     * Assign backend model to file upload input type
     *
     * @param  Varien_Event_Observer $observer
     * @return GhoSter_FileAttribute_Model_Observer
     */
    public function assignBackendModelToAttribute(Varien_Event_Observer $observer)
    {
        $backendModel = 'ghoster_fileattribute/attribute_backend_file';

        /** @var $object Mage_Eav_Model_Entity_Attribute_Abstract */
        $object = $observer->getEvent()->getAttribute();

        if ($object->getFrontendInput() == 'ghoster_file') {
            $object->setBackendModel($backendModel);
            $object->setBackendType('varchar');
        }

        return $this;
    }

    /**
     * Exclude 'ghoster_file' attributes from standard form generation
     *
     * @param   Varien_Event_Observer $observer
     * @return  GhoSter_FileAttribute_Model_Observer
     */
    public function updateExcludedFieldList(Varien_Event_Observer $observer)
    {
        $block = $observer->getEvent()->getObject();
        $list = $block->getFormExcludedFieldList();

        $attributes = Mage::getModel('eav/entity_attribute')->getAttributeCodesByFrontendType('ghoster_file');
        $list = array_merge($list, array_values($attributes));

        $block->setFormExcludedFieldList($list);

        return $this;
    }

    /**
     * Assign frontend model to file upload input type
     *
     * @param  Varien_Event_Observer $observer
     * @return GhoSter_FileAttribute_Model_Observer
     */
    public function updateElementTypes(Varien_Event_Observer $observer)
    {
        $response = $observer->getEvent()->getResponse();

        $types = $response->getTypes();
        $types['ghoster_file'] = Mage::getConfig()->getBlockClassName('ghoster_fileattribute/element_file');

        $response->setTypes($types);

        return $this;
    }

    /**
     * Change file attribute display output
     *
     * @param  Varien_Event_Observer $observer
     * @return void
     */
    public function changeFileAttributeOutput(Varien_Event_Observer $observer)
    {
        $outputHelper = $observer->getHelper();
        $helper = Mage::helper('ghoster_fileattribute');
        $outputHelper->addHandler('productAttribute', $helper);
    }
}
