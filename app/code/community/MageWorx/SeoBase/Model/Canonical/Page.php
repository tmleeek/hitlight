<?php
/**
 * MageWorx
 * MageWorx SeoBase Extension
 *
 * @category   MageWorx
 * @package    MageWorx_SeoBase
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */


class MageWorx_SeoBase_Model_Canonical_Page extends MageWorx_SeoBase_Model_Canonical_Abstract
{
    protected function _getCanonicalUrl($item = null)
    {
        if (Mage::getSingleton('cms/page')
            && Mage::registry('current_cms_hierarchy_node')
            && Mage::helper('mageworx_seobase')->isUseRootCmsPageForCanonicalUrl()
        ) {
            return Mage::helper('cms/page')->getPageUrl(Mage::getSingleton('cms/page')->getPageId());
        }
        return $this->trailingSlash($this->_cropGetParameters(Mage::helper('core/url')->getCurrentUrl()));
    }

}