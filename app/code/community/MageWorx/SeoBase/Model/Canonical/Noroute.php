<?php
/**
 * MageWorx
 * MageWorx SeoBase Extension
 *
 * @category   MageWorx
 * @package    MageWorx_SeoBase
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_SeoBase_Model_Canonical_Noroute extends MageWorx_SeoBase_Model_Canonical_Abstract
{
    protected function _getCanonicalUrl($item = null)
    {
        if ($this->_helperData->isUseCanonicalUrlFor404Page()) {
            return Mage::getBaseUrl() . Mage::getStoreConfig('web/default/cms_no_route');
        }
        return false;
    }

}