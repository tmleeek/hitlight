<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/18/16
 * Time: 10:56 AM
 */
class GhoSter_SocialCount_Block_Twitter extends Mage_Core_Block_Template
{
    protected $client = null;


    protected $shareCountLink = null;

    protected function _construct()
    {
        parent::_construct();

        $this->client = Mage::getModel('ghoster_socialcount/twitter_client');


        $this->shareCountLink = Mage::getSingleton('ghoster_socialcount/twitter_client')->createCountUrl();

        $this->setTemplate('ghoster/socialcount/twitter/share_count.phtml');

    }
}
