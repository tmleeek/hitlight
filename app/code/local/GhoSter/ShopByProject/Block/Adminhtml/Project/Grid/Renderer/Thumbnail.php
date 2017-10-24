<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/12/16
 * Time: 10:27 AM
 */
class GhoSter_ShopByProject_Block_Adminhtml_Project_Grid_Renderer_Thumbnail extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row)
    {
        $image = $row->getData($this->getColumn()->getIndex());
        if (isset($image)) {
            $html = '<img src="' . $image .'" style="max-width:160px; max-height:100px;"/>';
        } else {
            $html = '';
        }

        return $html;
    }
}
