<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/18/16
 * Time: 9:00 AM
 */
class GhoSter_SocialCount_Block_Linkedin extends Mage_Core_Block_Template
{
    protected $client = null;


    protected $shareCountLink = null;

    protected function _construct()
    {
        parent::_construct();

        $this->client = Mage::getModel('ghoster_socialcount/facebook_client');

        $this->shareCountLink = Mage::getSingleton('ghoster_socialcount/facebook_client')->createCountUrl();

        $this->setTemplate('ghoster/socialcount/linkedin/share_count.phtml');

    }
}
