<?php
/**
* @author Evince Team
* @copyright Evince
* @package Evince_Customattribute
*/
class Evince_Customattribute_Block_Customer_Form_Login extends Mage_Customer_Block_Form_Login
{
    protected function _toHtml()
    {
        $html = parent::_toHtml();
        if (Mage::getStoreConfig('customattribute/login/login_field') && Mage::getStoreConfig('customattribute/login/modify_title'))
        {
            $attributesHash = Mage::helper('customattribute')->getAttributesHash();
            if (isset($attributesHash[Mage::getStoreConfig('customattribute/login/login_field')]))
            {
                if (!Mage::getStoreConfig('customattribute/login/disable_email'))
                {
                    $replaceWith = $this->__('Email Address') . '/' . $attributesHash[Mage::getStoreConfig('customattribute/login/login_field')];
                } else 
                {
                    $replaceWith = $attributesHash[Mage::getStoreConfig('customattribute/login/login_field')];
                }
                $html = str_replace($this->__('Email Address'), $replaceWith, $html);
                $html = str_replace('validate-email', '', $html);
            }
        }
        return $html;
    }
}