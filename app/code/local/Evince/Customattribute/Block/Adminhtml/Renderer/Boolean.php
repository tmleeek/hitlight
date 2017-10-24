<?php
/**
* @author Evince
* @copyright Evince
* @package Evince_Customattribute
*/
class Evince_Customattribute_Block_Adminhtml_Renderer_Boolean extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        return $row->getData($this->getColumn()->getIndex()) ? 'Yes' : 'No';
    }
}