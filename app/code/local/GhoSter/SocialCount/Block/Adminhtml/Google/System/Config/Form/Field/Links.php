<?php

class GhoSter_SocialCount_Block_Adminhtml_Google_System_Config_Form_Field_Links
    extends GhoSter_SocialCount_Block_Adminhtml_System_Config_Form_Field_Links
{

    protected function getAuthProviderLink()
    {
        return 'Google Developers Console';
    }

    protected function getAuthProviderLinkHref()
    {
        return 'https://console.developers.google.com/';
    }
    
}