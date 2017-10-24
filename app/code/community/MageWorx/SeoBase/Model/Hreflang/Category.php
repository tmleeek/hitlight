<?php
/**
 * MageWorx
 * MageWorx SeoBase Extension
 *
 * @category   MageWorx
 * @package    MageWorx_SeoBase
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_SeoBase_Model_Hreflang_Category extends MageWorx_SeoBase_Model_Hreflang_Abstract
{

    protected function _getHreflangUrls() {

        $itemId        = '';
        $hreflangUrls  = array();

        $currentUrl       = Mage::helper('core/url')->getCurrentUrl();
        $isFiltersApplyed = Mage::helper('mageworx_seobase/layeredFilter')->applyedLayeredNavigationFilters();

        if (strpos($currentUrl, '?') === false && !$isFiltersApplyed) {
            $itemId = Mage::getSingleton('catalog/layer')->getCurrentCategory()->getId();
            if (!$itemId) {
                return null;
            }

            $hreflangCodes = Mage::helper('mageworx_seobase/alternate')->getAlternateFinalCodes('category');
            if (empty($hreflangCodes)) {
                return null;
            }

            $hreflangResource = Mage::helper('mageworx_seobase/factory')->getCategoryAlternateUrlResource();
            $hreflangUrlsCollection = $hreflangResource->getAllCategoryUrls(array_keys($hreflangCodes), $itemId);

            if (empty($hreflangUrlsCollection[$itemId]['alternateUrls'])) {
                return null;
            }

            foreach ($hreflangUrlsCollection[$itemId]['alternateUrls'] as $store => $altUrl) {
                $hreflang = $hreflangCodes[$store];
                $hreflangUrls[$hreflang] = $altUrl;
            }
        }
        return (!empty($hreflangUrls)) ? $hreflangUrls : null;
    }
}

