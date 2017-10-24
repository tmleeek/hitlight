<?php
/**
* @author Evince
* @copyright Evince
* @package Evince_Customattribute
*/
class Evince_Customattribute_Block_Adminhtml_Renderer_File extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        if (!$currentData = $row->getData($this->getColumn()->getIndex())) {
            return 'No Uploaded File';
        }
        
        $downloadUrl = Mage::helper('customattribute')->getAttributeFileUrl($currentData, true);
        $fileName = Mage::helper('customattribute')->cleanFileName($currentData);
        return '<a href="'. $downloadUrl .'">' . $fileName[3] . '</a>';
    }
}