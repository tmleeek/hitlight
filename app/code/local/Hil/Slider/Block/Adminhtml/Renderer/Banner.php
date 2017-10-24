<?php
class Hil_Slider_Block_Adminhtml_Renderer_Banner
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /* Render Grid Column*/
    public function render(Varien_Object $row)
    {
        return '<img style="width: 60px;" src="'. Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).$row->getBannerImage() .'">';
    }
}