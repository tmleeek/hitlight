<?php

class Cyberfision_Custom_Model_Source_Attribute extends Mage_Eav_Model_Entity_Attribute_Source_Abstract {
    public function getAllOptions()
    {
        $attributes = Mage::getResourceModel('eav/entity_attribute_collection')
            ->addFieldToSelect(array('attribute_code', 'frontend_label'))
            ->addFieldToFilter('entity_type_id', '4')
            ->addFieldToFilter('frontend_input', 'select');

        $op_attribute = array();

        array_push($op_attribute, array('label' => '-- Select attribute(s) --', 'value' => ''));

        foreach($attributes as $attribute) {
            array_push($op_attribute, array('label' => $attribute->getFrontendLabel(), 'value' => $attribute->getAttributeCode()));
        }

        return $op_attribute;
    }
}