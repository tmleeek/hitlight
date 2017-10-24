<?php
/**
* @author Evince Team
* @copyright Evince
* @package Evince_Customattribute
*/
class Evince_Customattribute_Model_System_Config_Source_Attributes
{
    public function toOptionArray()
    {
        $hash      = Mage::helper('customattribute')->getAttributesHash();
        $options   = array();
        $options[] = array('value'  => '', 'label' => Mage::helper('customattribute')->__('- Magento Default (E-mail) -'));
        foreach ($hash as $key => $option)
        {
            $options[] = array('value'  => $key, 'label' => $option);
        }
        return $options;
    }
}