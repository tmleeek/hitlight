<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/18/16
 * Time: 9:03 AM
 */
class GhoSter_SocialCount_Helper_Linkedin extends Mage_Core_Helper_Abstract
{
    CONST NO_SHARE_COUNT = 0;

    public function getLinkedinShareCount($url)
    {

        $jsonObject = json_decode(Mage::getModel('ghoster_socialcount/linkedin_client')->getShareCount($url));


        if (isset($jsonObject->count)) {
            return $jsonObject->count;
        }

        return GhoSter_SocialCount_Helper_Linkedin::NO_SHARE_COUNT;
    }
}
