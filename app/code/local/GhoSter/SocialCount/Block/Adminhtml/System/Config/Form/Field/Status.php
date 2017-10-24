<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/18/16
 * Time: 2:46 PM
 */
abstract class GhoSter_SocialCount_Block_Adminhtml_System_Config_Form_Field_Status
    extends Mage_Adminhtml_Block_System_Config_Form_Field
{

    protected function _getUnRegisteredStatus()
    {
        return Mage::helper('ghoster_socialcount')->__('Unregistered');
    }

    protected function _getRegisteredStatus() {
        return Mage::helper('ghoster_socialcount')->__('Registered');
    }

    protected function getAuthProviderLinkHref()
    {
        return '';
    }

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        return sprintf(
            '<a href="%s" target="_blank">%s</a>',
            $this->getAuthProviderLinkHref(),
            $this->getStatus()
        );
    }


    public function getStatus()
    {
        $status = json_decode(Mage::getSingleton('ghoster_socialcount/twitter_client')->getShareCount(Mage::getBaseUrl()));

        if(isset($status->error)) {
            return $this->_getUnRegisteredStatus();
        }

        return $this->_getRegisteredStatus();
    }
}
