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
class Magegiant_Onestepcheckout_IndexController extends Mage_Checkout_Controller_Action
{
    /**
     * @return Magegiant_Onestepcheckout_IndexController
     */
    public function preDispatch()
    {
        parent::preDispatch();
        $this->_preDispatchValidateCustomer();

        $checkoutSessionQuote = Mage::getSingleton('checkout/session')->getQuote();
        if ($checkoutSessionQuote->getIsMultiShipping()) {
            $checkoutSessionQuote->setIsMultiShipping(false);
            $checkoutSessionQuote->removeAllAddresses();
        }

        if (!$this->_canShowForUnregisteredUsers()) {
            $this->norouteAction();
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);

            return;
        }

        return $this;
    }

    public function indexAction()
    {
        if (!Mage::helper('onestepcheckout/config')->isEnabled()) {
            Mage::getSingleton('checkout/session')->addError($this->__('The onestep checkout is disabled.'));
            $this->_redirect('checkout/cart');

            return;
        }
        Mage::helper('use_type_customer')->addItemFlashlights() ;
        $quote = $this->getOnepage()->getQuote();

        Mage::getSingleton('checkout/session')->setCartWasUpdated(false);
        $this->getOnepage()->initCheckout();

        //need set billing and shipping data from session
        $currentData = Mage::getSingleton('checkout/session')->getData('onestepcheckout_form_values');
        if ($currentData && array_key_exists('billing', $currentData)) {
            if (isset($currentData['billing_address_id'])) {
                Mage::helper('onestepcheckout/address')->saveBilling($currentData['billing'], $currentData['billing_address_id']);
            }

            if (isset($currentData['billing']['use_for_shipping'])
                && $currentData['billing']['use_for_shipping'] == 0
                && isset($currentData['shipping_address_id'])
            ) {
                Mage::helper('onestepcheckout/address')->saveShipping($currentData['shipping'], $currentData['shipping_address_id']);
            }
        }

        Mage::helper('onestepcheckout/address')->initAddress();
        Mage::helper('onestepcheckout/shipping')->initShippingMethod();
        Mage::helper('onestepcheckout/payment')->initPaymentMethod();

        // Reset Enterprise Giftwrap reset present card.
        $wrappingInfo = array('gw_add_card' => false);
        if ($this->getOnepage()->getQuote()->getShippingAddress()) {
            $this->getOnepage()->getQuote()->getShippingAddress()->addData($wrappingInfo);
        }
        $this->getOnepage()->getQuote()->addData($wrappingInfo);
        // Reset Enterprise Giftwrap reset present card.

        $this->getOnepage()->getQuote()->setTotalsCollectedFlag(false);
        $this->getOnepage()->getQuote()->collectTotals()->save();
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->getLayout()->getBlock('head')->setTitle(Mage::helper('onestepcheckout/config')->getCheckoutTitle());
        $this->renderLayout();
    }

    public function getOnepage()
    {
        return Mage::getSingleton('checkout/type_onepage');
    }

    protected function _canShowForUnregisteredUsers()
    {
        return Mage::getSingleton('customer/session')->isLoggedIn()
        || $this->getRequest()->getActionName() == 'index'
        || Mage::helper('checkout')->isAllowedGuestCheckout($this->getOnepage()->getQuote())
        || !Mage::helper('onestepcheckout')->isCustomerMustBeLogged();
    }

    public function addProductAction()
    {
        $products   = Mage::getModel('catalog/product')
            ->getCollection();
        $product_id = null;
        foreach ($products as $product) {
            $stock_item = $product->getStockItem();
            if ($stock_item && $stock_item->getIsInStock() == 1) {
                $product_id = $product->getId();
                break;
            }
        }
        $cart = Mage::getSingleton('checkout/cart');
        try {
            $cart->addProduct(Mage::getModel('catalog/product')->load($product_id));
            $cart->save();
        } catch (Exception $e) {
        }
        $this->_redirect('onestepcheckout/index');
        return;
    }
}