<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/6/16
 * Time: 9:47 AM
 */
class GhoSter_Common_Helper_Image extends Mage_Core_Helper_Abstract
{

    protected $_mediadir ='/media/';


    /**
     * Check media url
     *  if(contain /media/)
     *      return domain
     *      else
     *          return null
     *
     * @param $image_url
     * @return mixed|null
     */
    public function getImagePath($image_url)
    {
        if ($image_url) {
            return str_replace('/', DS, ltrim($image_url, $this->_mediadir));
        }

        return null;
    }
}
