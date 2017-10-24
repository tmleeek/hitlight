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
class Magegiant_Onestepcheckout_Model_Updater
{
    const TARGET_LAYOUT_FULL_ACTION_NAME = 'onestepcheckout_index_index';

    const SHIPPING_METHOD_BLOCK_NAME  = 'onestepcheckout.onestep.form.shippingmethod';
    const PAYMENT_METHOD_BLOCK_NAME   = 'onestepcheckout.onestep.form.paymentmethod';
    const REVIEW_CART_BLOCK_NAME      = 'onestepcheckout.onestep.form.review.cart';
    const REVIEW_CART_TOTAL           = 'onestepcheckout.onestep.form.review.total';
    const TOPCART_ITEMS               = 'onestepcheckout.minicart.total';
    const TOPCART                     = 'cart_sidebar';
    const REVIEW_COUPON_BLOCK_NAME    = 'onestepcheckout.onestep.form.review.coupon';
    const TOP_LINK_BLOCK_NAME         = 'top.links';
    const RELATED_PRODUCTS_BLOCK_NAME = 'onestepcheckout.onestep.related';
    const CART_SIDEBAR                = 'minicart_head';
    /*===Custom Rule Block===*/
    const CUSTOM_BLOCK_ONESTEPCHECKOUT_TOP    = 'onestepcheckout.customblock.top';
    const CUSTOM_BLOCK_ONESTEPCHECKOUT_BOTTOM = 'onestepcheckout.customblock.bottom';
    /*===/Custom Rule Block===*/
    /*====Intergrate Enterprise===*/
    const REVIEW_ENTERPRISE_GIFTCARD_BLOCK_NAME    = 'onestepcheckout.onestep.form.review.enterprise.giftcard';
    const REVIEW_ENTERPRISE_POINTS_BLOCK_NAME      = 'onestepcheckout.onestep.form.review.enterprise.points';
    const REVIEW_ENTERPRISE_STORECREDIT_BLOCK_NAME = 'onestepcheckout.onestep.form.review.enterprise.storecredit';
    /*====/Intergrate Enterprise===*/
    protected $_map = array(
        'saveAddress'                => array(
            'shipping_method'               => self::SHIPPING_METHOD_BLOCK_NAME,
            'payment_method'                => self::PAYMENT_METHOD_BLOCK_NAME,
            'review_cart'                   => self::REVIEW_CART_BLOCK_NAME,
            'review_coupon'                 => self::REVIEW_COUPON_BLOCK_NAME,
            'review_enterprise_giftcard'    => self::REVIEW_ENTERPRISE_GIFTCARD_BLOCK_NAME,
            'review_enterprise_storecredit' => self::REVIEW_ENTERPRISE_STORECREDIT_BLOCK_NAME,
            'review_enterprise_points'      => self::REVIEW_ENTERPRISE_POINTS_BLOCK_NAME,
        ),
        'saveShippingMethod'         => array(
            'payment_method'                => self::PAYMENT_METHOD_BLOCK_NAME,
            'review_cart'                   => self::REVIEW_CART_BLOCK_NAME,
            'review_coupon'                 => self::REVIEW_COUPON_BLOCK_NAME,
            'review_enterprise_giftcard'    => self::REVIEW_ENTERPRISE_GIFTCARD_BLOCK_NAME,
            'review_enterprise_storecredit' => self::REVIEW_ENTERPRISE_STORECREDIT_BLOCK_NAME,
            'review_enterprise_points'      => self::REVIEW_ENTERPRISE_POINTS_BLOCK_NAME,
            'review_total'        => self::REVIEW_CART_TOTAL,
        ),
        'addEnterprisePrintedCard'   => array(
            'payment_method'                => self::PAYMENT_METHOD_BLOCK_NAME,
            'review_cart'                   => self::REVIEW_CART_BLOCK_NAME,
            'review_coupon'                 => self::REVIEW_COUPON_BLOCK_NAME,
            'review_enterprise_giftcard'    => self::REVIEW_ENTERPRISE_GIFTCARD_BLOCK_NAME,
            'review_enterprise_storecredit' => self::REVIEW_ENTERPRISE_STORECREDIT_BLOCK_NAME,
            'review_enterprise_points'      => self::REVIEW_ENTERPRISE_POINTS_BLOCK_NAME,
            'review_total'        => self::REVIEW_CART_TOTAL,
        ),
        'savePaymentMethod'          => array(
            'review_cart'                   => self::REVIEW_CART_BLOCK_NAME,
            'review_coupon'                 => self::REVIEW_COUPON_BLOCK_NAME,
            'review_enterprise_giftcard'    => self::REVIEW_ENTERPRISE_GIFTCARD_BLOCK_NAME,
            'review_enterprise_storecredit' => self::REVIEW_ENTERPRISE_STORECREDIT_BLOCK_NAME,
            'review_enterprise_points'      => self::REVIEW_ENTERPRISE_POINTS_BLOCK_NAME,
            'review_total'        => self::REVIEW_CART_TOTAL,
        ),
        'ajaxCartItem'               => array(
            'review_cart'         => self::REVIEW_CART_BLOCK_NAME,
//            'shipping_method'     => self::SHIPPING_METHOD_BLOCK_NAME,
            'payment_method'      => self::PAYMENT_METHOD_BLOCK_NAME,
            'custom_block_top'    => self::CUSTOM_BLOCK_ONESTEPCHECKOUT_TOP,
            'custom_block_bottom' => self::CUSTOM_BLOCK_ONESTEPCHECKOUT_BOTTOM,
            'related'             => self::RELATED_PRODUCTS_BLOCK_NAME,
            'cart_sidebar'        => self::CART_SIDEBAR,
            'review_total'        => self::REVIEW_CART_TOTAL,
            'minicart_total'      => self::TOPCART_ITEMS,
            'minicart_total_mobile'      => self::TOPCART_ITEMS,
            'minicart'            => self::TOPCART,
        ),
        'applyGiantPoints'           => array(
            'review_cart'                   => self::REVIEW_CART_BLOCK_NAME,
            'payment_method'                => self::PAYMENT_METHOD_BLOCK_NAME,
            'review_enterprise_giftcard'    => self::REVIEW_ENTERPRISE_GIFTCARD_BLOCK_NAME,
            'review_enterprise_storecredit' => self::REVIEW_ENTERPRISE_STORECREDIT_BLOCK_NAME,
            'review_enterprise_points'      => self::REVIEW_ENTERPRISE_POINTS_BLOCK_NAME,
            'review_total'        => self::REVIEW_CART_TOTAL,
        ),
        'addGiftWrap'                => array(
            'review_cart' => self::REVIEW_CART_BLOCK_NAME,
            'review_total'        => self::REVIEW_CART_TOTAL,
        ),
        'applyCoupon'                => array(
            'payment_method'                => self::PAYMENT_METHOD_BLOCK_NAME,
            'review_cart'                   => self::REVIEW_CART_BLOCK_NAME,
            'review_enterprise_storecredit' => self::REVIEW_ENTERPRISE_STORECREDIT_BLOCK_NAME,
            'review_enterprise_points'      => self::REVIEW_ENTERPRISE_POINTS_BLOCK_NAME,
        ),
        'applyEnterpriseGiftcard'    => array(
            'payment_method'                => self::PAYMENT_METHOD_BLOCK_NAME,
            'review_cart'                   => self::REVIEW_CART_BLOCK_NAME,
            'review_coupon'                 => self::REVIEW_COUPON_BLOCK_NAME,
            'review_enterprise_storecredit' => self::REVIEW_ENTERPRISE_STORECREDIT_BLOCK_NAME,
            'review_enterprise_points'      => self::REVIEW_ENTERPRISE_POINTS_BLOCK_NAME,
        ),
        'removeEnterpriseGiftcard'   => array(
            'payment_method'                => self::PAYMENT_METHOD_BLOCK_NAME,
            'review_cart'                   => self::REVIEW_CART_BLOCK_NAME,
            'review_coupon'                 => self::REVIEW_COUPON_BLOCK_NAME,
            'review_enterprise_giftcard'    => self::REVIEW_ENTERPRISE_GIFTCARD_BLOCK_NAME,
            'review_enterprise_storecredit' => self::REVIEW_ENTERPRISE_STORECREDIT_BLOCK_NAME,
            'review_enterprise_points'      => self::REVIEW_ENTERPRISE_POINTS_BLOCK_NAME,
        ),
        'applyEnterpriseStorecredit' => array(
            'payment_method'             => self::PAYMENT_METHOD_BLOCK_NAME,
            'review_cart'                => self::REVIEW_CART_BLOCK_NAME,
            'review_coupon'              => self::REVIEW_COUPON_BLOCK_NAME,
            'review_enterprise_giftcard' => self::REVIEW_ENTERPRISE_GIFTCARD_BLOCK_NAME,
            'review_enterprise_points'   => self::REVIEW_ENTERPRISE_POINTS_BLOCK_NAME,
        ),
        'applyEnterprisePoints'      => array(
            'payment_method'                => self::PAYMENT_METHOD_BLOCK_NAME,
            'review_cart'                   => self::REVIEW_CART_BLOCK_NAME,
            'review_coupon'                 => self::REVIEW_COUPON_BLOCK_NAME,
            'review_enterprise_giftcard'    => self::REVIEW_ENTERPRISE_GIFTCARD_BLOCK_NAME,
            'review_enterprise_storecredit' => self::REVIEW_ENTERPRISE_STORECREDIT_BLOCK_NAME,
        ),
        'addProductToWishlist'       => array(
            'top_links' => self::TOP_LINK_BLOCK_NAME,
            'related'   => self::RELATED_PRODUCTS_BLOCK_NAME
        ),
        'addProductToCompareList'    => array(
            'related' => self::RELATED_PRODUCTS_BLOCK_NAME
        ),
        'updateBlocksAfterACP'       => array(
            'related'         => self::RELATED_PRODUCTS_BLOCK_NAME,
            'shipping_method' => self::SHIPPING_METHOD_BLOCK_NAME,
            'payment_method'  => self::PAYMENT_METHOD_BLOCK_NAME,
            'review_cart'     => self::REVIEW_CART_BLOCK_NAME,
            'review_coupon'   => self::REVIEW_COUPON_BLOCK_NAME,
        )
    );

    /**
     * @param null $controller
     *
     * @return array
     */
    public function getBlocks($layout = null, $fullTargetActionName = null)
    {
        if (is_null($layout)) {
            $layout = Mage::app()->getLayout();
        }
        if (is_null($fullTargetActionName)) {
            $fullTargetActionName = self::TARGET_LAYOUT_FULL_ACTION_NAME;
        }
        $this->_initLayout($layout, $fullTargetActionName);

        $actionName = Mage::app()->getRequest()->getActionName();
        if (!array_key_exists($actionName, $this->_map)) {
            return array();
        }
        if (!is_array($this->_map[$actionName])) {
            return array();
        }
        $blocks = array();
        foreach ($this->_map[$actionName] as $key => $blockName) {
            $block = $layout->getBlock($blockName);
            if ($block) {
                $blocks[$key] = $block->toHtml();
            }
        }

        return $blocks;
    }

    /**
     * @return array
     */
    public function getMap()
    {
        return $this->_map;
    }

    protected function _initLayout($layout, $fullTargetActionName)
    {
        /* -- START-- copypaste from Mage_Core_Controller_Varien_Action -- START -- */
        $update = $layout->getUpdate();
        $update->addHandle('default'); //load default handle
        $update->addHandle('STORE_' . Mage::app()->getStore()->getCode()); // load store handle
        $package = Mage::getSingleton('core/design_package');
        $update->addHandle(
            'THEME_' . $package->getArea() . '_' . $package->getPackageName() . '_' . $package->getTheme('layout')
        ); // load theme handle
        $update->addHandle(strtolower($fullTargetActionName)); // load action handle
        Mage::dispatchEvent(
            'controller_action_layout_load_before',
            array('action' => Mage::app()->getFrontController()->getAction(), 'layout' => $layout)
        );
        $update->load();
        $layout->generateXml();
        $layout->generateBlocks();
        /* -- END -- copypaste from Mage_Core_Controller_Varien_Action -- END -- */
    }
}