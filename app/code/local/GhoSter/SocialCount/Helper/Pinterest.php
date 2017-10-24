<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/18/16
 * Time: 9:15 AM
 */
class GhoSter_SocialCount_Helper_Pinterest extends Mage_Core_Helper_Abstract
{
    CONST NO_SHARE_COUNT = 0;

    public function getPinterestShareCount($url)
    {

        $jsonObject = json_decode(Mage::getModel('ghoster_socialcount/pinterest_client')->getShareCount($url));


        if (isset($jsonObject->count)) {
            return $jsonObject->count;
        }

        return GhoSter_SocialCount_Helper_Pinterest::NO_SHARE_COUNT;
    }
}
