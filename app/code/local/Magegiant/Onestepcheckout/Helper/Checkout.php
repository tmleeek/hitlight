<?php

/**
 * Magegiant
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magegiant.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magegiant.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Magegiant
 * @package     Magegiant_Onestepcheckout
 * @copyright   Copyright (c) 2012 Magegiant (http://www.magegiant.com/)
 * @license     http://www.magegiant.com/license-agreement.html
 */
class Magegiant_Onestepcheckout_Helper_Checkout extends Mage_Core_Helper_Data
{
    public function getDeleteUrl($item)
    {
        $giantOscIndexPageUrl   = Mage::getUrl('onestepcheckout/index/index');
        $giantOscEncodedPageUrl = Mage::helper('core/url')->getEncodedUrl($giantOscIndexPageUrl);

        return Mage::getModel('core/url')->getUrl(
            'checkout/cart/delete',
            array(
                'id'                                                      => $item->getId(),
                Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED => $giantOscEncodedPageUrl,
            )
        );
    }
}