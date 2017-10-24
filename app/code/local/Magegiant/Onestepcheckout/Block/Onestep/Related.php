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


class Magegiant_Onestepcheckout_Block_Onestep_Related extends Mage_Checkout_Block_Onepage_Abstract
{
    protected $_timerConfig = array(
        'block_html_id'                 => 'giant-onestepcheckout-related-redirect-timer-block',
        'timer_clock_html_id'           => 'giant-onestepcheckout-related-redirect-timer-clock',
        'redirect_now_action_html_id'   => 'giant-onestepcheckout-related-redirect-timer-action-redirect',
        'cancel_action_html_id'         => 'giant-onestepcheckout-related-redirect-timer-action-cancel',
        'title_text'                    => "You will be redirected to another page in %s second(s).",
        'description_text'              => "You can lose your order progress.",
        'redirect_now_action_text'      => "Redirect Now",
        'cancel_action_text'            => "Cancel",
    );

    public function canShow()
    {
        if (!Mage::helper('onestepcheckout/config')->isRelatedProducts()) {
            return false;
        }
        return true;
    }
    public function getHelperTimerBlockHtml()
    {
        $block = $this->getLayout()->createBlock(
            'onestepcheckout/onestep_helper_timer',
            'giant.onestepcheckout.relate.timer',
            $this->_timerConfig
        );
        return $block->toHtml();
    }

    public function getUrlToAddProductToWishlist()
    {
        return Mage::getUrl(
            'onestepcheckout/ajax/addProductToWishlist',
            array(
                '_secure'  => true,
                'form_key' => Mage::getSingleton('core/session')->getFormKey(),
            )
        );
    }

    public function getUrlToAddProductToCompareList()
    {
        return Mage::getUrl(
            'onestepcheckout/ajax/addProductToCompareList',
            array(
                '_secure'  => true,
                'form_key' => Mage::getSingleton('core/session')->getFormKey(),
            )
        );
    }

    public function getAjaxCartItemUrl()
    {
        return Mage::getUrl('onestepcheckout/ajax/ajaxCartItem', array('_secure'=>true));
    }
}