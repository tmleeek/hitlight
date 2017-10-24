<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/17/16
 * Time: 6:28 PM
 */
class GhoSter_SocialCount_Helper_Facebook extends Mage_Core_Helper_Abstract
{

    CONST NO_SHARE_COUNT = 0;

    public function getFacebookShareCount($url)
    {

        $jsonObject = json_decode(Mage::getModel('ghoster_socialcount/facebook_client')->getShareCount($url));

        if (isset($jsonObject->shares)) {
            return $jsonObject->shares;
        }


        if(isset($jsonObject->share)) {
            return $jsonObject->share->share_count;
        }

        return GhoSter_SocialCount_Helper_Facebook::NO_SHARE_COUNT;
    }
}
