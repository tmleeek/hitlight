<?php
class Cyberfision_Brandshow_Model_Source_Brand extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    public function getAllOptions()
    {
        $brandCollection = Mage::getModel('cyberfision_brand/brand')->getCollection()->setOrder('name', 'ASC');
        
        $options = array(
            array(
                'label' => '',
                'value' => '',
            ),
        );
        
        foreach ($brandCollection as $_brand) {
            $options[] = array(
                'label' => $_brand->getName(),
                'value' => $_brand->getId(),
            );
        }
        
        return $options;
    }
}