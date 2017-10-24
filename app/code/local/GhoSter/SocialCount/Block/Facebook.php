<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/17/16
 * Time: 3:52 PM
 */
class GhoSter_SocialCount_Block_Facebook extends Mage_Core_Block_Template
{
    protected $client = null;


    protected $shareCountLink = null;

    protected function _construct()
    {
        parent::_construct();

        $this->client = Mage::getSingleton('ghoster_socialcount/facebook_client');


        $this->shareCountLink = Mage::getModel('ghoster_socialcount/facebook_client')->createCountUrl();

        $this->setTemplate('ghoster/socialcount/facebook/share_count.phtml');

    }
}
