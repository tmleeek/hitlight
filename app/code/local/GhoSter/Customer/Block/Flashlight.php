<?php
class GhoSter_Customer_Block_Flashlight extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract {
    public function _prepareToRender()
    {
        $this->addColumn('flashlight_subtotal_price', array(
            'label' => Mage::helper('use_type_customer')->__('Subtotal Price'),
            'style' => 'width: 200px',
        ));
        $this->addColumn('flashlight_product_sku', array(
            'label' => Mage::helper('use_type_customer')->__('Product SKU'),
            'style' => 'width: 300px',
        ));

        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('use_type_customer')->__('Add');
    }
}