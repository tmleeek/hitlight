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
class Magegiant_Onestepcheckout_AjaxController extends Mage_Checkout_Controller_Action
{

    /**
     * @return Magegiant_Onestepcheckout_AjaxController|Mage_Core_Controller_Front_Action
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

        return $this;
    }

    /**
     * action for customer login
     */
    public function customerLoginAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        $customerSession = Mage::getSingleton('customer/session');
        $result          = array(
            'success'  => true,
            'messages' => array()
        );
        if (!$customerSession->isLoggedIn()) {
            $login = $this->getRequest()->getPost('login');
            if (!empty($login['username']) && !empty($login['password'])) {
                try {
                    $customerSession->login($login['username'], $login['password']);
                } catch (Mage_Core_Exception $e) {
                    switch ($e->getCode()) {
                        case Mage_Customer_Model_Customer::EXCEPTION_EMAIL_NOT_CONFIRMED:
                            $value   = Mage::helper('customer')->getEmailConfirmationUrl($login['username']);
                            $message = $this->__('This account is not confirmed. <a href="%s">Click here</a> to resend confirmation email.', $value);
                            break;
                        case Mage_Customer_Model_Customer::EXCEPTION_INVALID_EMAIL_OR_PASSWORD:
                            $message = $e->getMessage();
                            break;
                        default:
                            $message = $e->getMessage();
                    }
                    $result['success']    = false;
                    $result['messages'][] = $message;
                    $customerSession->setUsername($login['username']);
                } catch (Exception $e) {
                    $result['success']    = false;
                    $result['messages'][] = $this->__("Oops something's wrong");
                    //TODO: think about redirect to login page
                }
            } else {
                $result['success']    = false;
                $result['messages'][] = $this->__('Login and password are required.');
            }
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    /**
     * action for customer forgot password
     */
    public function customerForgotPasswordAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        $customerSession = Mage::getSingleton('customer/session');
        $result          = array(
            'success'  => true,
            'messages' => array()
        );
        $email           = (string)$this->getRequest()->getPost('email');
        if ($email) {
            if (Zend_Validate::is($email, 'EmailAddress')) {
                /** @var $customer Mage_Customer_Model_Customer */
                $customer = Mage::getModel('customer/customer')
                    ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                    ->loadByEmail($email);
                if ($customer->getId()) {
                    try {
                        Mage::helper('onestepcheckout/customer')->sendForgotPasswordForCustomer($customer);
                    } catch (Exception $exception) {
                        $result['success']    = false;
                        $result['messages'][] = $exception->getMessage();
                    }
                }
            } else {
                $customerSession->setForgottenEmail($email);
                $result['success']    = false;
                $result['messages'][] = $this->__('Invalid email address.');
            }
        } else {
            $result['success']    = false;
            $result['messages'][] = $this->__('Please enter your email.');
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    public function saveFormValuesAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        $result = array(
            'success'  => true,
            'messages' => array(),
        );
        if ($this->getRequest()->isPost()) {
            $newData = $this->getRequest()->getPost();
            //store ddan date as Zend_Date object
            if (array_key_exists('giant_deliverydate_date', $newData)) {
                try {
                    $newData['giant_deliverydate_date']
                        = Mage::helper('onestepcheckout/ddan')->getDateFromPost($newData['giant_deliverydate_date']);
                } catch (Exception $e) {
                }
            }
            $currentData = Mage::getSingleton('checkout/session')->getData('onestepcheckout_form_values');
            if (!is_array($currentData)) {
                $currentData = array();
            }
            Mage::getSingleton('checkout/session')->setData(
                'onestepcheckout_form_values', array_merge($currentData, $newData)
            );
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    /**
     * save checkout billing address
     */
    public function saveAddressAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        $result = array(
            'success'     => true,
            'messages'    => array(),
            'blocks'      => array(),
            'grand_total' => ""
        );
        if ($this->getRequest()->isPost()) {
            $data              = $this->getRequest()->getPost('billing', array());
            $customerAddressId = $this->getRequest()->getPost('billing_address_id', false);

            if (isset($data['email'])) {
                $data['email'] = trim($data['email']);
            }
            $saveBillingResult = Mage::helper('onestepcheckout/address')->saveBilling($data, $customerAddressId);
            $usingCase         = isset($data['use_for_shipping']) ? (int)$data['use_for_shipping'] : 0;
            if ($usingCase === 0) {
                $data               = $this->getRequest()->getPost('shipping', array());
                $customerAddressId  = $this->getRequest()->getPost('shipping_address_id', false);
                $saveShippingResult = Mage::helper('onestepcheckout/address')->saveShipping($data, $customerAddressId);
            }
            if (isset($saveShippingResult)) {
                $saveResult = array_merge($saveBillingResult, $saveShippingResult);
            } else {
                $saveResult = $saveBillingResult;
            }

            if (isset($saveResult['error'])) {
                $result['success'] = false;
                if (is_array($saveResult['message'])) {
                    $result['messages'] = array_merge($result['messages'], $saveResult['message']);
                } else {
                    $result['messages'][] = $saveResult['message'];
                }
            }
            $shippingRates = $this->getOnepage()->getQuote()->getShippingAddress()
                ->collectTotals()
                ->collectShippingRates()
                ->getAllShippingRates();
            //if single shipping rate available then apply it as shipping method
            if (count($shippingRates) == 1) {
                $shippingMethod = $shippingRates[0]->getCode();
                $this->getOnepage()->getQuote()->getShippingAddress()->setShippingMethod($shippingMethod);
            }
            $this->getOnepage()->getQuote()->collectTotals()->save();
            $result['blocks']      = $this->getUpdater()->getBlocks();
            $result['grand_total'] = Mage::helper('onestepcheckout')->getGrandTotal($this->getOnepage()->getQuote());
        } else {
            $result['success']    = false;
            $result['messages'][] = $this->__('Please specify billing address information.');
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    /**
     * Shipping method save
     */
    public function saveShippingMethodAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        $result = array(
            'success'     => true,
            'messages'    => array(),
            'blocks'      => array(),
            'grand_total' => ""
        );
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost('shipping_method', '');
            /*Hack for Magegiant Storepickup*/
            if ($data != 'storepickup_storepickup') {
                Mage::getSingleton('checkout/session')->setData('storepickup_session', array());
            }
            $saveResult = $this->getOnepage()->saveShippingMethod($data);
            Mage::dispatchEvent(
                'checkout_controller_onepage_save_shipping_method',
                array(
                    'request' => $this->getRequest(),
                    'quote'   => $this->getOnepage()->getQuote()
                )
            );
            if (isset($saveResult['error'])) {
                $result['success']    = false;
                $result['messages'][] = $saveResult['message'];
            }
            $this->getOnepage()->getQuote()->setTotalsCollectedFlag(false)->collectTotals()->save();
            $result['blocks']      = $this->getUpdater()->getBlocks();
            $result['grand_total'] = Mage::helper('onestepcheckout')->getGrandTotal($this->getOnepage()->getQuote());
        } else {
            $result['success']    = false;
            $result['messages'][] = $this->__('Please specify shipping method.');
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }
    /*==========Intergrate Enterprise==========*/
    /**
     * Add Enterprise printed card (Giftwrap)
     */
    public function addEnterprisePrintedCardAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        $result = array(
            'success'              => true,
            'messages'             => array(),
            'blocks'               => array(),
            'grand_total'          => "",
            'printed_card_applied' => false,
        );
        if (!$this->getOnepage()->getQuote()->getItemsCount()) {
            $result['success'] = false;
        } else {
            try {
                $quote = $this->getOnepage()->getQuote();

                $wrappingInfo                = array();
                $wrappingInfo['gw_add_card'] = (bool)$this->getRequest()->getParam('add_printed_card');

                if ($quote->getShippingAddress()) {
                    $quote->getShippingAddress()->addData($wrappingInfo);
                }
                $quote->addData($wrappingInfo);

                $this->getOnepage()->getQuote()->getShippingAddress()->setCollectShippingRates(true);
                $this->getOnepage()->getQuote()->setTotalsCollectedFlag(false);
                $this->getOnepage()->getQuote()->collectTotals()->save();

                $result['blocks']               = $this->getUpdater()->getBlocks();
                $result['grand_total']          = Mage::helper('onestepcheckout')->getGrandTotal($this->getOnepage()->getQuote());
                $result['printed_card_applied'] = $wrappingInfo['gw_add_card'];
            } catch (Mage_Core_Exception $e) {
                $result['success']    = false;
                $result['messages'][] = $e->getMessage();
            } catch (Exception $e) {
                $result['success']    = false;
                $result['messages'][] = $this->__('Cannot add Printed Card.');
                Mage::logException($e);
            }
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    public function applyEnterpriseStorecreditAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        $result = array(
            'success'     => true,
            'messages'    => array(),
            'blocks'      => array(),
            'grand_total' => ""
        );
        if (!$this->getOnepage()->getQuote()->getItemsCount()) {
            $result['success'] = false;
        } else {
            try {
                $quote = $this->getOnepage()->getQuote();

                $store = Mage::app()->getStore($quote->getStoreId());
                if (
                    !$quote
                    || !$quote->getCustomerId()
                    || $quote->getBaseGrandTotal() + $quote->getBaseCustomerBalanceAmountUsed() <= 0
                ) {
                    $result['success'] = false;
                }

                $quote->setUseCustomerBalance((bool)$this->getRequest()->getParam('use_customer_balance'));
                if ($quote->getUseCustomerBalance()) {
                    $balance = Mage::getModel('enterprise_customerbalance/balance')
                        ->setCustomerId($quote->getCustomerId())
                        ->setWebsiteId($store->getWebsiteId())
                        ->loadByCustomer();
                    if ($balance) {
                        $quote->setCustomerBalanceInstance($balance);
                        if (!$quote->getPayment()->getMethod()) {
                            $quote->getPayment()->setMethod('free');
                        }
                        $result['messages'][] = $this->__('Store credit was applied.');
                    } else {
                        $quote->setUseCustomerBalance(false);
                        $result['messages'][] = $this->__(
                            'Store Credit payment is not being used in your shopping cart.'
                        );
                    }
                } else {
                    $quote->setUseCustomerBalance(false);
                    $result['messages'][] = $this->__('The store credit payment has been removed from the order.');
                }

                $this->getOnepage()->getQuote()->getShippingAddress()->setCollectShippingRates(true);
                $this->getOnepage()->getQuote()->setTotalsCollectedFlag(false);
                $this->getOnepage()->getQuote()->collectTotals()->save();

                $result['blocks']      = $this->getUpdater()->getBlocks();
                $result['grand_total'] = Mage::helper('onestepcheckout')->getGrandTotal($this->getOnepage()->getQuote());
            } catch (Mage_Core_Exception $e) {
                $result['success']    = false;
                $result['messages'][] = $e->getMessage();
            } catch (Exception $e) {
                $result['success']    = false;
                $result['messages'][] = $this->__('Cannot apply the Store Credit.');
                Mage::logException($e);
            }
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    public function applyEnterprisePointsAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        $result = array(
            'success'     => true,
            'messages'    => array(),
            'blocks'      => array(),
            'grand_total' => ""
        );
        if (!$this->getOnepage()->getQuote()->getItemsCount()) {
            $result['success'] = false;
        } else {
            try {
                $quote = $this->getOnepage()->getQuote();
                if (
                    !$quote
                    || !$quote->getCustomerId()
                    || $quote->getBaseGrandTotal() + $quote->getBaseRewardCurrencyAmount() <= 0
                ) {
                    $result['success'] = false;
                }

                $quote->setUseRewardPoints((bool)$this->getRequest()->getParam('use_reward_points'));
                if ($quote->getUseRewardPoints()) {
                    /* @var $reward Enterprise_Reward_Model_Reward */
                    $reward = Mage::getModel('enterprise_reward/reward')
                        ->setCustomer($quote->getCustomer())
                        ->setWebsiteId($quote->getStore()->getWebsiteId())
                        ->loadByCustomer();

                    $minPointsBalance = (int)Mage::getStoreConfig(
                        Enterprise_Reward_Model_Reward::XML_PATH_MIN_POINTS_BALANCE,
                        $quote->getStoreId()
                    );

                    if ($reward->getId() && $reward->getPointsBalance() >= $minPointsBalance) {
                        $quote->setRewardInstance($reward);
                        if (!$quote->getPayment()->getMethod()) {
                            $quote->getPayment()->setMethod('free');
                        }
                        $result['messages'][] = $this->__('Reward points was applied.');
                    } else {
                        $quote->setUseRewardPoints(false);
                        $result['messages'][] = $this->__('Reward points will not be used in this order.');
                    }
                } else {
                    $quote->setUseRewardPoints(false);
                    $result['messages'][] = $this->__('The reward points have been removed from the order.');
                }

                $this->getOnepage()->getQuote()->getShippingAddress()->setCollectShippingRates(true);
                $this->getOnepage()->getQuote()->setTotalsCollectedFlag(false);
                $this->getOnepage()->getQuote()->collectTotals()->save();

                $result['blocks']      = $this->getUpdater()->getBlocks();
                $result['grand_total'] = Mage::helper('onestepcheckout')->getGrandTotal($this->getOnepage()->getQuote());
            } catch (Mage_Core_Exception $e) {
                $result['success']    = false;
                $result['messages'][] = $e->getMessage();
            } catch (Exception $e) {
                $result['success']    = false;
                $result['messages'][] = $this->__('Cannot apply the %s.', Mage::helper('onestepcheckout/enterprise_points')->getPointsUnitName());
                Mage::logException($e);
            }
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    public function applyEnterpriseGiftcardAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        $result       = array(
            'success'     => false,
            'messages'    => array(),
            'blocks'      => array(),
            'grand_total' => ""
        );
        $giftcardCode = (string)$this->getRequest()->getParam('enterprise_giftcard_code');
        if (isset($giftcardCode)
            || !(strlen($giftcardCode) > Enterprise_GiftCardAccount_Helper_Data::GIFT_CARD_CODE_MAX_LENGTH)
        ) {
            try {
                Mage::getModel('enterprise_giftcardaccount/giftcardaccount')
                    ->loadByCode($giftcardCode)
                    ->addToCart();
                $result['success']    = true;
                $result['messages'][] = Mage::helper('enterprise_giftcardaccount')->__('Gift Card "%s" was added.',
                    Mage::helper('core')->escapeHtml($giftcardCode));
                $this->getOnepage()->getQuote()->collectTotals()->save();
                $result['blocks']      = $this->getUpdater()->getBlocks();
                $result['grand_total'] = Mage::helper('onestepcheckout')->getGrandTotal(
                    $this->getOnepage()->getQuote());
            } catch (Mage_Core_Exception $e) {
                Mage::dispatchEvent(
                    'enterprise_giftcardaccount_add', array('status' => 'fail', 'code' => $giftcardCode)
                );
                $result['messages'][] = $e->getMessage();
            } catch (Exception $e) {
                $result['messages'][] = Mage::helper('enterprise_giftcardaccount')->__('Cannot apply gift card.');
            }
        } else {
            $result['messages'][] = Mage::helper('enterprise_giftcardaccount')->__('Wrong gift card code.');
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    public function removeEnterpriseGiftcardAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        $result       = array(
            'success'     => false,
            'messages'    => array(),
            'blocks'      => array(),
            'grand_total' => ""
        );
        $giftcardCode = (string)$this->getRequest()->getParam('enterprise_giftcard_code');
        if (isset($giftcardCode)
            || !(strlen($giftcardCode) > Enterprise_GiftCardAccount_Helper_Data::GIFT_CARD_CODE_MAX_LENGTH)
        ) {
            try {
                Mage::getModel('enterprise_giftcardaccount/giftcardaccount')
                    ->loadByCode($giftcardCode)
                    ->removeFromCart();
                $result['success']    = true;
                $result['messages'][] = Mage::helper('enterprise_giftcardaccount')->__('Gift Card "%s" was removed.',
                    Mage::helper('core')->escapeHtml($giftcardCode));
                $this->getOnepage()->getQuote()->collectTotals()->save();
                $result['blocks']      = $this->getUpdater()->getBlocks();
                $result['grand_total'] = Mage::helper('onestepcheckout')->getGrandTotal(
                    $this->getOnepage()->getQuote());
            } catch (Mage_Core_Exception $e) {
                $result['messages'][] = $e->getMessage();
            } catch (Exception $e) {
                $result['messages'][] = Mage::helper('enterprise_giftcardaccount')->__('Cannot remove gift card.');
            }
        } else {
            $result['messages'][] = Mage::helper('enterprise_giftcardaccount')->__('Wrong gift card code.');
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }
    /*========== /Intergrate Enterprise==========*/
    /**
     * Payment method save
     */
    public function savePaymentMethodAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        $result = array(
            'success'     => true,
            'messages'    => array(),
            'blocks'      => array(),
            'grand_total' => ""
        );
        try {
            if ($this->getRequest()->isPost()) {
                $data = $this->getRequest()->getPost('payment', array());

                $session    = Mage::getSingleton('checkout/session');
                $saveResult = $this->getOnepage()->savePayment($data);
                if (isset($saveResult['error'])) {
                    $result['success']    = false;
                    $result['messages'][] = $saveResult['message'];
                }
                $this->getOnepage()->getQuote()->collectTotals()->save();
                $result['blocks']      = $this->getUpdater()->getBlocks();
                $result['grand_total'] = Mage::helper('onestepcheckout')->getGrandTotal($this->getOnepage()->getQuote());
            } else {
                $result['success']    = false;
                $result['messages'][] = $this->__('Please specify payment method.');
            }
        } catch (Exception $e) {
            Mage::logException($data);
            $result['success'] = false;
            $result['error'][] = $this->__('Unable to set Payment Method.');
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    public function applyCouponAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        $result = array(
            'success'        => true,
            'coupon_applied' => false,
            'messages'       => array(),
            'blocks'         => array(),
            'grand_total'    => ""
        );
        if (!$this->getOnepage()->getQuote()->getItemsCount()) {
            $result['success'] = false;
        } else {
            $couponCode    = (string)$this->getRequest()->getParam('coupon_code');
            $oldCouponCode = $this->getOnepage()->getQuote()->getCouponCode();
            if (!strlen($couponCode) && !strlen($oldCouponCode)) {
                $result['success'] = false;
            } else {
                try {
                    $this->getOnepage()->getQuote()->getShippingAddress()->setCollectShippingRates(true);
                    $this->getOnepage()->getQuote()->setCouponCode(strlen($couponCode) ? $couponCode : '')
                        ->collectTotals()
                        ->save();
                    if ($couponCode == $this->getOnepage()->getQuote()->getCouponCode()) {
                        $this->getOnepage()->getQuote()->getShippingAddress()->setCollectShippingRates(true);
                        $this->getOnepage()->getQuote()->setTotalsCollectedFlag(false);
                        $this->getOnepage()->getQuote()->collectTotals()->save();
                        Mage::getSingleton('checkout/session')->getMessages(true);
                        if (strlen($couponCode)) {
                            $result['coupon_applied'] = true;
                            $result['messages'][]     = $this->__('Coupon code was applied.');
                        } else {
                            $result['coupon_applied'] = false;
                            $result['messages'][]     = $this->__('Coupon code was canceled.');
                        }
                    } else {
                        $result['success']    = false;
                        $result['messages'][] = $this->__('Coupon code is not valid.');
                    }
                    $result['blocks']      = $this->getUpdater()->getBlocks();
                    $result['grand_total'] = Mage::helper('onestepcheckout')->getGrandTotal($this->getOnepage()->getQuote());
                } catch (Mage_Core_Exception $e) {
                    $result['success']    = false;
                    $result['messages'][] = $e->getMessage();
                } catch (Exception $e) {
                    $result['success']    = false;
                    $result['messages'][] = $this->__('Cannot apply the coupon code.');
                    Mage::logException($e);
                }
            }
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    public function placeOrderAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        $result = array(
            'success'  => true,
            'messages' => array(),
        );
        try {
            //TODO: re-factoring. Move to helpers
            if ($this->getRequest()->isPost()) {
                $billingData = $this->getRequest()->getPost('billing', array());
                // save checkout method
                if (!$this->getOnepage()->getCustomerSession()->isLoggedIn()) {
                    if (isset($billingData['create_account'])) {
                        $this->getOnepage()->saveCheckoutMethod(Mage_Checkout_Model_Type_Onepage::METHOD_REGISTER);
                    } else {
                        $this->getOnepage()->saveCheckoutMethod(Mage_Checkout_Model_Type_Onepage::METHOD_GUEST);
                    }
                }

                if (!$this->getOnepage()->getQuote()->getCustomerId() &&
                    Mage_Checkout_Model_Type_Onepage::METHOD_REGISTER == $this->getOnepage()->getQuote()->getCheckoutMethod()
                ) {
                    if ($this->_customerEmailExists($billingData['email'], Mage::app()->getWebsite()->getId())) {
                        $result['success']    = false;
                        $result['messages'][] = $this->__('There is already a customer registered using this email address. Please login using this email address or enter a different email address to register your account.');
                    }
                }

                if ($result['success']) {
                    // save billing address
                    $customerAddressId = $this->getRequest()->getPost('billing_address_id', false);
                    if (isset($billingData['email'])) {
                        $billingData['email'] = trim($billingData['email']);
                    }
                    $saveBillingResult = $this->getOnepage()->saveBilling($billingData, $customerAddressId);
                    if(trim($billingData['telephone'])=='_-___-___-____'){
                        $saveBillingResult['error'] = true;
                        $saveBillingResult['message'] = array('The telephone is invalid');
                    }

                    //save shipping address
                    if (!isset($billingData['use_for_shipping'])) {
                        $shippingData       = $this->getRequest()->getPost('shipping', array());
                        $customerAddressId  = $this->getRequest()->getPost('shipping_address_id', false);
                        $saveShippingResult = $this->getOnepage()->saveShipping($shippingData, $customerAddressId);
                        if(trim($shippingData['telephone'])=='_-___-___-____'){
                            $saveShippingResult['error'] = true;
                            $saveShippingResult['message'] = array('The telephone is invalid');
                        }
                    }

                    // check errors
                    if (isset($saveShippingResult)) {
                        $saveResult = array_merge($saveBillingResult, $saveShippingResult);
                    } else {
                        $saveResult = $saveBillingResult;
                    }

                    //for compatibility with gift options when shipping method is single (not applying)
                    Mage::dispatchEvent(
                        'checkout_controller_onepage_save_shipping_method',
                        array(
                            'request' => $this->getRequest(),
                            'quote'   => $this->getOnepage()->getQuote()
                        )
                    );

                    if (isset($saveResult['error'])) {
                        $result['success'] = false;
                        if (!is_array($saveResult['message'])) {
                            $saveResult['message'] = array($saveResult['message']);
                        }
                        $result['messages'] = array_merge($result['messages'], $saveResult['message']);
                    } else {
                        // check agreements
                        $requiredAgreements = Mage::helper('checkout')->getRequiredAgreementIds();
                        $postedAgreements   = array_keys($this->getRequest()->getPost('giant_osc_agreement', array()));
                        if ($diff = array_diff($requiredAgreements, $postedAgreements) && Mage::helper('onestepcheckout/config')->isEnabledTerm()) {
                            $result['success']    = false;
                            $result['messages'][] = $this->__('Please agree to all the terms and conditions before placing the order.');
                        } else {
                            if ($data = $this->getRequest()->getPost('payment', false)) {
                                $this->getOnepage()->getQuote()->getPayment()->importData($data);
                            }
                            //is used delivery time
                            $is_used_delivery_time = $this->getRequest()->getPost('enabled_delivery_time', false);
                            if ($is_used_delivery_time) {
                                $delivery = $this->getRequest()->getPost('delivery', array());
                            } else {
                                $delivery = array();
                            }
                            //save data for use after order save
                            $data = array(
                                'comments'                        => $this->getRequest()->getPost('comments', false),
                                'delivery'                        => $delivery,
                                'onestepcheckout_survey_answer'   => $this->getRequest()->getPost('onestepcheckout_survey_answer', false),
                                'onestepcheckout_survey_question' => $this->getRequest()->getPost('onestepcheckout_survey_question', false),
                                'is_subscribed'                   => $this->getRequest()->getPost('is_subscribed', false),
                                'billing'                         => $this->getRequest()->getPost('billing', array()),
                                'segments_select'                 => $this->getRequest()->getPost('segments_select', array())
                            );
                            Mage::getSingleton('checkout/session')->setData('onestepcheckout_order_data', $data);

                            /* Compatibility for Mage_Authorizenet DPM */
                            if (@class_exists('Mage_Authorizenet_Model_Directpost_Session')) {
                                Mage::getSingleton('authorizenet/directpost_session')->setQuoteId(
                                    $this->getOnepage()->getQuote()->getId()
                                );
                            }
                            // 3D Secure
                            $method = $this->getOnepage()->getQuote()->getPayment()->getMethodInstance();
                            if ($method->getIsCentinelValidationEnabled()) {
                                $centinel = $method->getCentinelValidator();
                                if ($centinel && $centinel->shouldAuthenticate()) {
                                    $layout = $this->getLayout();
                                    $update = $layout->getUpdate();
                                    $update->load('onestepcheckout_index_saveorder');
                                    $this->_initLayoutMessages('checkout/session');
                                    $layout->generateXml();
                                    $layout->generateBlocks();
                                    $html                     = $layout->getBlock('centinel.frame')->toHtml();
                                    $result['is_centinel']    = true;
                                    $result['update_section'] = array(
                                        'name' => 'paypaliframe',
                                        'html' => $html
                                    );
                                    $result['success']        = false;

                                    return $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));

                                }
                            }
                            // \3D Secure
                            /* Compatibility for Ebizmarts_SagePaySuite */
                            $paymentHelper = Mage::helper('onestepcheckout/payment');
                            $paymentMethod = $this->getOnepage()->getQuote()->getPayment()->getMethod();
                            if ($paymentHelper->isEbizmartsSagePaySuiteMethod($paymentMethod)) {
                                $redirectUrl = $this->_processEbizmartsSagePaySuite();
                            } else {
                                $redirectUrl = $this
                                    ->getOnepage()
                                    ->getQuote()
                                    ->getPayment()
                                    ->getCheckoutRedirectUrl();
                                if (!$redirectUrl) {
                                    $this->getOnepage()->saveOrder();
                                    /* Compatibility for Mage_Authorizenet DPM */
                                    if ($paymentMethod == 'authorizenet_directpost') {
                                        $dpm      = Mage::helper('onestepcheckout/payment_authorizenet_directpost');
                                        $dpmError = $dpm->process(
                                            $this->getRequest()->getPost('payment', false)
                                        );
                                        if ($dpmError) {
                                            throw new Exception($dpmError);
                                        }
                                    }
                                    $redirectUrl = $this->getOnepage()->getCheckout()->getRedirectUrl();
                                }
                            }
                            /*\Sagepay Intergrate*/

                        }
                    }
                }
            } else {
                $result['success'] = false;
            }
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::helper('checkout')->sendPaymentFailedEmail($this->getOnepage()->getQuote(), $e->getMessage());
            $result['success']    = false;
            $result['messages'][] = $this->__('There was an error processing your order. Please contact us or try again later.');
            $result['messages'][] = $e->getMessage();
        }
        if ($result['success']) {
            $this->getOnepage()->getQuote()->save();
            if (isset($redirectUrl)) {
                $result['redirect'] = $redirectUrl;
            }
        }

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    /**
     *
     */
    public function addProductToWishlistAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        $result                     = array(
            'success'  => true,
            'messages' => array()
        );
        $customerSession            = Mage::getSingleton('customer/session');
        $wishlistSession            = Mage::getSingleton('wishlist/session');
        $response                   = clone $this->getResponse();
        $wishlistControllerInstance = $this->_getCustomerWishlistController($this->getRequest(), $response);
        if (!is_null($wishlistControllerInstance) && method_exists($wishlistControllerInstance, 'addAction')) {
            $wishlistControllerInstance->addAction();
            $wishlistMessagesCollection = $wishlistSession->getMessages(true);
            $customerMessageCollection  = $customerSession->getMessages(true);
            $successMessages            = array_merge(
                $wishlistMessagesCollection->getItemsByType(Mage_Core_Model_Message::SUCCESS),
                $customerMessageCollection->getItemsByType(Mage_Core_Model_Message::SUCCESS)
            );
            if (count($successMessages) === 0) {
                //if something wrong
                $result['success'] = false;
                $product           = Mage::getModel('catalog/product')->load($this->getRequest()->getParam('product', 0));
                if (!is_null($product->getId())) {
                    $referer              = $product->getUrlModel()->getUrl($product, array());
                    $result['messages'][] =
                        $this->__(
                            'Product "%1$s" has not been added. Please add it <a href="%2$s">from product page</a>',
                            $product->getName(),
                            $referer
                        );
                }
            } else {
                $result['blocks'] = $this->getUpdater()->getBlocks();
                $product          = Mage::getModel('catalog/product')->load($this->getRequest()->getParam('product', 0));
                if (!is_null($product->getId())) {
                    $result['messages'][] =
                        $this->__(
                            'Product "%1$s" was successfully added to wishlist',
                            $product->getName()
                        );
                } else {
                    $result['messages'][] = $this->__('Product was successfully added to wishlist');
                }
            }
        } else {
            $result['success']    = false;
            $result['messages'][] = $this->__("Oops something's wrong");
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    /**
     *
     */
    public function addProductToCompareListAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        $result                           = array(
            'success'  => true,
            'messages' => array()
        );
        $catalogSession                   = Mage::getSingleton('catalog/session');
        $response                         = clone $this->getResponse();
        $productCompareControllerInstance = $this->_getProductCompareController($this->getRequest(), $response);
        if (!is_null($productCompareControllerInstance) && method_exists($productCompareControllerInstance, 'addAction')) {
            $productCompareControllerInstance->addAction();
            $messageCollection = $catalogSession->getMessages(true);
            $successMessages   = $messageCollection->getItemsByType(Mage_Core_Model_Message::SUCCESS);
            if (count($successMessages) === 0) {
                //if something wrong
                $result['success'] = false;
                $product           = Mage::getModel('catalog/product')->load($this->getRequest()->getParam('product', 0));
                if (!is_null($product->getId())) {
                    $referer              = $product->getUrlModel()->getUrl($product, array());
                    $result['messages'][] =
                        $this->__(
                            'Product "%1$s" has not been added. Please add it <a href="%2$s">from product page</a>',
                            $product->getName(),
                            $referer
                        );
                }
            } else {
                $result['blocks'] = $this->getUpdater()->getBlocks();
                $product          = Mage::getModel('catalog/product')->load($this->getRequest()->getParam('product', 0));
                if (!is_null($product->getId())) {
                    $result['messages'][] =
                        $this->__(
                            'Product "%1$s" was successfully added to compare list',
                            $product->getName()
                        );
                } else {
                    $result['messages'][] = $this->__('Product was successfully added to compare list');
                }
            }
        } else {
            $result['success']    = false;
            $result['messages'][] = $this->__("Oops something's wrong");
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    /**
     * @return Mage_Checkout_Model_Type_Onepage
     */
    public function getOnepage()
    {
        return Mage::getSingleton('checkout/type_onepage');
    }

    /**
     * @return Magegiant_Onestepcheckout_Model_Updater
     */
    public function getUpdater()
    {
        return Mage::getSingleton('onestepcheckout/updater');
    }

    /**
     * Check can page show for unregistered users
     *
     * @return boolean
     */
    protected function _canShowForUnregisteredUsers()
    {
        //TODO: show login block only for unregistered
        return Mage::getSingleton('customer/session')->isLoggedIn()
        || Mage::helper('checkout')->isAllowedGuestCheckout($this->getOnepage()->getQuote())
        || !Mage::helper('checkout')->isCustomerMustBeLogged();
    }

    /**
     * @return Magegiant_Onestepcheckout_AjaxController
     */
    protected function _ajaxRedirectResponse()
    {
        $this->getResponse()
            ->setHeader('HTTP/1.1', '403 Session Expired')
            ->setHeader('Login-Required', 'true')
            ->sendResponse();

        return $this;
    }

    /**
     * @return bool
     */
    protected function _expireAjax()
    {
        if (!$this->getOnepage()->getQuote()->hasItems()
            || $this->getOnepage()->getQuote()->getHasError()
            || $this->getOnepage()->getQuote()->getIsMultiShipping()
        ) {
            $this->_ajaxRedirectResponse();

            return true;
        }
        if (Mage::getSingleton('checkout/session')->getCartWasUpdated(true)) {
            $this->_ajaxRedirectResponse();

            return true;
        }

        return false;
    }


    /**
     * helper
     *
     * @return null|Mage_Core_Controller_Front_Action
     */
    private function _getCustomerWishlistController($request, $response)
    {
        $fbIntegratorModuleName = 'Mage_Wishlist';
        $controllerName         = 'index';

        return $this->_createController($fbIntegratorModuleName, $controllerName, $request, $response);
    }

    /**
     * helper
     *
     * @return null|Mage_Core_Controller_Front_Action
     */
    private function _getProductCompareController($request, $response)
    {
        $fbIntegratorModuleName = 'Mage_Catalog';
        $controllerName         = 'product_compare';

        return $this->_createController($fbIntegratorModuleName, $controllerName, $request, $response);
    }

    /**
     * helper
     *
     * @param $moduleName
     * @param $controllerName
     * @param $request
     * @param $response
     *
     * @return Mage_Core_Controller_Front_Action|null
     */
    private function _createController($moduleName, $controllerName, $request, $response)
    {
        $router             = Mage::app()->getFrontController()->getRouter('standard');
        $controllerFileName = $router->getControllerFileName($moduleName, $controllerName);
        if (!$router->validateControllerFileName($controllerFileName)) {
            return null;
        }
        $controllerClassName = $router->getControllerClassName($moduleName, $controllerName);
        if (!$controllerClassName) {
            return null;
        }

        if (!class_exists($controllerClassName, false)) {
            if (!file_exists($controllerFileName)) {
                return null;
            }
            include $controllerFileName;

            if (!class_exists($controllerClassName, false)) {
                return null;
            }
        }
        $controllerInstance = Mage::getControllerInstance(
            $controllerClassName,
            $request,
            $response
        );

        return $controllerInstance;
    }

    /**
     * Check if customer email exists
     *
     * @param string $email
     * @param int    $websiteId
     * @return false|Mage_Customer_Model_Customer
     */
    protected function _customerEmailExists($email, $websiteId = null)
    {
        $customer = Mage::getModel('customer/customer');
        if ($websiteId) {
            $customer->setWebsiteId($websiteId);
        }
        $customer->loadByEmail($email);
        if ($customer->getId()) {
            return $customer;
        }

        return false;
    }

    protected function _processEbizmartsSagePaySuite()
    {
        switch ($this->getOnepage()->getQuote()->getPayment()->getMethod()) {
            case 'sagepaypaypal':
                return Mage::getModel('core/url')->addSessionParam()->getUrl('sgps/paypalexpress/go', array('_secure' => true));
            case 'sagepayserver':
                $this->_forward('saveOrder', 'serverPayment', 'sgps', $this->getRequest()->getParams());
                break;
            case 'sagepaydirectpro':
                $this->_forward('saveOrder', 'directPayment', 'sgps', $this->getRequest()->getParams());
                break;
            case 'sagepayform':
                $this->_forward('saveOrder', 'formPayment', 'sgps', $this->getRequest()->getParams());
                break;
            default:
                return null;
        }
    }

    /**
     *
     */
    public function ajaxCartItemAction()
    {
        if ($this->_expireAjax()) {
            return;
        }

        $action = $this->getRequest()->getParam('action');
        $id     = $this->getRequest()->getParam('id');
        $qty    = $this->getRequest()->getParam('qty');

        $string = '';
        switch ($action) {
            case 'plus':
            case 'minus':
                $string = $this->_updateCartItem($action, (int)$id);
                break;
            case 'changeQty':
                $string = $this->_updateCartItemQty((int)$id, $qty);
                break;
            case 'delAll':
                $string = $this->_removeCartItems($id) ? false : true;
                break;
            default:
                $string = $this->_removeCartItem((int)$id) ? false : true;
        }
    }

    /**
     * @param $action
     * @param $id
     */
    protected function _updateCartItem($action, $id)
    {
        $cart      = $this->_getCart();
        $quoteItem = $cart->getQuote()->getItemById($id);
        $qty       = $quoteItem->getQty();
        $result    = array();
        if ($id) {
            try {
                if (isset($qty)) {
                    $filter = new Zend_Filter_LocalizedToNormalized(
                        array('locale' => Mage::app()->getLocale()->getLocaleCode())
                    );
                    $qty    = $filter->filter($qty);
                }
                if (!$quoteItem) {
                    Mage::throwException($this->__('Quote item is not found.'));
                }
                if ($action == 'plus')
                    $qty++;
                else $qty--;
                if ($qty == 0) {
                    $cart->removeItem($id);
                } else {
                    $quoteItem->setQty($qty)->save();
                }
                $this->_getCart()->save();
                $message = $cart->getQuote()->getMessages();
                if ($message) {
                    $result['error'] = $message['qty']->getCode();
                    $quoteItem->setQty($qty - 1)->save();
                    $this->_getCart()->save();
                }
                if (!$quoteItem->getHasError()) {
                    $result['success'] = 1;
                } else {
                    $result['success'] = 0;
                }
            } catch (Mage_Core_Exception $e) {
                $result['success'] = 0;
                $result['error']   = Mage::helper('core')->escapeHtml($e->getMessage());
            } catch (Exception $e) {
                $result['success'] = 0;
                $result['error']   = $this->__('Can not save item.');
            }
            if (array_key_exists('error', $result)) {
                $this->getResponse()->setHeader('Content-type', 'application/json');
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
            } else {
                $this->_updateOrderReview();
            }
        }
    }

    /**
     * @param $action
     * @param $id
     * @param $qty
     */
    protected function _updateCartItemQty($id, $qty)
    {
        $cart      = $this->_getCart();
        $quoteItem = $cart->getQuote()->getItemById($id);

        $result    = array();
        if ($id) {
            try {
                if (isset($qty)) {
                    $filter = new Zend_Filter_LocalizedToNormalized(
                        array('locale' => Mage::app()->getLocale()->getLocaleCode())
                    );
                    $qty    = $filter->filter($qty);
                }
                if (!$quoteItem) {
                    Mage::throwException($this->__('Quote item is not found.'));
                }

                if ($qty == 0) {
                    $cart->removeItem($id);
                } else {
                    $quoteItem->setQty($qty)->save();
                }
                $this->_getCart()->save();
                $message = $cart->getQuote()->getMessages();
                if ($message) {
                    $result['error'] = $message['qty']->getCode();
                    $quoteItem->setQty($qty - 1)->save();
                    $this->_getCart()->save();
                }
                if (!$quoteItem->getHasError()) {
                    $result['success'] = 1;
                } else {
                    $result['success'] = 0;
                }
            } catch (Mage_Core_Exception $e) {
                $result['success'] = 0;
                $result['error']   = Mage::helper('core')->escapeHtml($e->getMessage());
            } catch (Exception $e) {
                $result['success'] = 0;
                $result['error']   = $this->__('Can not save item.');
            }
            if (array_key_exists('error', $result)) {
                $this->getResponse()->setHeader('Content-type', 'application/json');
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
            } else {
                $this->_updateOrderReview();
            }
        }
    }

    /**
     * @param $id
     */
    protected function _removeCartItem($id)
    {
        $result = array();
        if ($id) {
            try {
                $this->_getCart()->removeItem($id)->save();
                $result['qty']     = $this->_getCart()->getSummaryQty();
                $result['success'] = 1;
            } catch (Exception $e) {
                $result['success'] = 0;
                $result['error']   = $e->getMessage();
            }
            if (array_key_exists('error', $result)) {
                $this->getResponse()->setHeader('Content-type', 'application/json');
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
            } else {
                $this->_updateOrderReview();
            }
        }
    }

    protected function _removeCartItems($ids)
    {
        $result = array();
        if ($ids) {
            try {
                $itemIds = explode(',', $ids);

                $cart = Mage::helper('checkout/cart')->getCart();
                foreach ($itemIds as $id){
                    $cart->removeItem($id);
                }
                $cart->save();
                $result['qty']     = $cart->getSummaryQty();
                $result['success'] = 1;
            } catch (Exception $e) {
                $result['success'] = 0;
                $result['error']   = $e->getMessage();
            }
            if (array_key_exists('error', $result)) {
                $this->getResponse()->setHeader('Content-type', 'application/json');
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
            } else {
                $this->_updateOrderReview();
            }
        }
    }

    /**
     * Retrieve shopping cart model object
     *
     * @return Mage_Checkout_Model_Cart
     */
    protected function _getCart()
    {
        return Mage::getSingleton('checkout/cart');
    }

    protected function _updateOrderReview()
    {
        $count = Mage::helper('use_type_customer')->addItemFlashlights();

        if ($this->_expireAjax()) {
            return;
        }
        $result = array(
            'success'     => true,
            'messages'    => array(),
            'blocks'      => array(),
            'grand_total' => ""
        );
        try {
            if ($this->getRequest()->isPost()) {
                $this->getOnepage()->getQuote()->collectTotals()->save();
                $result['blocks']      = $this->getUpdater()->getBlocks();
                $result['grand_total'] = Mage::helper('onestepcheckout')->getGrandTotal($this->getOnepage()->getQuote());
            } else {
                $result['success']    = false;
                $result['messages'][] = $this->__('Please specify payment method.');
            }
        } catch (Exception $e) {
            Mage::logException($e);
            $result['success'] = false;
            $result['error'][] = $this->__('Unable to update cart item');
        }
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $result['blocks']['minicart_total']+= $count;
        $result['blocks']['minicart_total_mobile']+= $count;
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    /**
     *
     */
    public function addGiftWrapAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        $is_used_giftwrap = $this->getRequest()->getParam('is_used_giftwrap', false);
        if ($is_used_giftwrap) {
            Mage::getSingleton('checkout/session')->setData('is_used_giftwrap', 1);
        } else {
            Mage::getSingleton('checkout/session')->setData('is_used_giftwrap', 0);
        }
        $this->_updateOrderReview();
    }

    public function applyGiantPointsAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        $session = Mage::getSingleton('checkout/session');
        $session->setRewardSalesRules(array(
            'rule_id'   => $this->getRequest()->getParam('reward_sales_rule'),
            'use_point' => $this->getRequest()->getParam('reward_sales_point'),
        ));
        $session->setData('use_point', $this->getRequest()->getParam('use_point'));
        $result = array(
            'success'  => true,
            'messages' => array(),
            'blocks'   => array(),
        );
        try {
            if ($this->getRequest()->isPost()) {
                $this->getOnepage()->getQuote()->collectTotals()->save();
                $result['blocks'] = $this->getUpdater()->getBlocks();
            } else {
                $result['success']    = false;
                $result['messages'][] = $this->__('Please specify payment method.');
            }
        } catch (Exception $e) {
            Mage::logException($e);
            $result['success'] = false;
            $result['error'][] = $this->__('Unable to update payment method');
        }
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }
}
