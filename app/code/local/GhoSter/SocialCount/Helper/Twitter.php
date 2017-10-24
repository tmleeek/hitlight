<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/18/16
 * Time: 10:56 AM
 */
class GhoSter_SocialCount_Helper_Twitter extends Mage_Core_Helper_Abstract
{
    CONST NO_SHARE_COUNT = 0;

    public function getTwitterShareCount($url)
    {

        $jsonObject = json_decode(Mage::getModel('ghoster_socialcount/twitter_client')->getShareCount($url));


        if (isset($jsonObject->count)) {
            return $jsonObject->count;
        }

        return GhoSter_SocialCount_Helper_Twitter::NO_SHARE_COUNT;
    }
}
