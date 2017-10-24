<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/11/16
 * Time: 11:49 AM
 */
class GhoSter_ShopByProject_Block_Adminhtml_Cms_Block_Edit_Renderer_Fieldset_Instruction extends Varien_Data_Form_Element_Abstract
{
    protected $_element;

    public function getElementHtml()
    {
        $status = $this->getValue();

        $html = '';

        if ($status == 1) {
            $html .= '<span style="color:green; font-weight: bold">' . Mage::helper('ghoster_shopbyproject')->__('Yes') . '</span>';
        } else {
            $html .= '<span style="color:red; font-weight: bold">' . Mage::helper('ghoster_shopbyproject')->__('No') . '</span>';
        }


        return $html;

    }
}
