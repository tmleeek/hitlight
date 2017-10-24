<?php
/**
* @author Evince Team
* @copyright Evince
* @package Evince_Customerattr
*/
class Evince_Customattribute_Block_Adminhtml_Customer_Relation extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'customattribute';
        $this->_controller = 'adminhtml_customer_relation';
        $this->_headerText = Mage::helper('customattribute')->__('Manage Attributes Relation');
        $this->_addButtonLabel = Mage::helper('customattribute')->__('Add New Relation');
        parent::__construct();
    }

}
