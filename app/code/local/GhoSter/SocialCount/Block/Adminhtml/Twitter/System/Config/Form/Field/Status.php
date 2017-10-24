<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/18/16
 * Time: 3:06 PM
 */
class GhoSter_SocialCount_Block_Adminhtml_Twitter_System_Config_Form_Field_Status extends GhoSter_SocialCount_Block_Adminhtml_System_Config_Form_Field_Status
{

    protected function _getUnRegisteredStatus()
    {
        return Mage::helper('ghoster_socialcount')->__('Unregistered - Click Here to register this domail with OpenShareCount');
    }

    protected function _getRegisteredStatus() {
        return Mage::helper('ghoster_socialcount')->__('Registered');
    }

    protected function getAuthProviderLinkHref()
    {
        return 'http://opensharecount.com';
    }
}
