<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/18/16
 * Time: 10:56 AM
 */
class GhoSter_SocialCount_Helper_Google extends Mage_Core_Helper_Abstract
{
    CONST NO_SHARE_COUNT = 0;

    public function getGoogleShareCount($url)
    {

        $jsonObject = json_decode(Mage::getModel('ghoster_socialcount/google_client')->getShareCount($url));


        if (isset($jsonObject->result->metadata->globalCounts->count)) {
            return intval($jsonObject->result->metadata->globalCounts->count);
        }

        return GhoSter_SocialCount_Helper_Google::NO_SHARE_COUNT;
    }
}
