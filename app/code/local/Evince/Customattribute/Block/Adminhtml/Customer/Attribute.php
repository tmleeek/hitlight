<?php
/**
* @author Evince Team
* @copyright Evince
* @package Evince_Customattribute
*/
class Evince_Customattribute_Block_Adminhtml_Customer_Attribute extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'customattribute';
        $this->_controller = 'adminhtml_customer_attribute';
        $this->_headerText = Mage::helper('customattribute')->__('Manage Customer Custom Attributes');
        $this->_addButtonLabel = Mage::helper('customattribute')->__('Add New Attribute');
        parent::__construct();
    }

}
