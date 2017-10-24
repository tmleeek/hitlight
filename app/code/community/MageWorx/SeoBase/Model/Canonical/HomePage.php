<?php
/**
 * MageWorx
 * MageWorx SeoBase Extension
 *
 * @category   MageWorx
 * @package    MageWorx_SeoBase
 * @copyright  Copyright (c) 2016 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_SeoBase_Model_Canonical_HomePage extends MageWorx_SeoBase_Model_Canonical_Abstract
{

    protected function _getCanonicalUrl($item = null)
    {
        $crossDomainStoreId = $this->_getCrossDomainStoreId();

        if ($crossDomainStoreId) {
            $url = $this->_helperStore->getStoreBaseUrl($crossDomainStoreId);
        } else {
            $url = Mage::getBaseUrl();
        }
        if ($this->_helperData->cropTrailingSlashForHomePageUrl()) {
            return trim($url, '/');
        }

        return $url;
    }

}