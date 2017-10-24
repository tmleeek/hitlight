<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/27/16
 * Time: 3:05 PM
 */
class GhoSter_ProductVideo_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getVideoThumb($url)
    {
        $id = $this->_getYoutubeVideoId($url);
        return 'http://img.youtube.com/vi/' . $id . '/default.jpg';
    }

    public function getVideoImage($url)
    {
        $id = $this->_getYoutubeVideoId($url);
        return 'http://img.youtube.com/vi/' . $id . '/maxresdefault.jpg';
    }

    public function getVideoEmbedLink($url)
    {
        $id = $this->_getYoutubeVideoId($url);
        return 'https://www.youtube.com/embed/' . $id . '?autoplay=1';
    }

    protected function _getYoutubeVideoId($url)
    {
        if (!$url) {

            return null;
        }

        parse_str(parse_url($url, PHP_URL_QUERY), $params);

        return isset($params['v']) ? $params['v'] : '';
    }

    public function getVideoUrls($product)
    {
        $_resource = Mage::getSingleton('catalog/product')->getResource();
        $dataJson = $_resource->getAttributeRawValue($product->getId(), 'video_url', Mage::app()->getStore());
        return Mage::helper('core')->jsonDecode($dataJson);
    }

}
