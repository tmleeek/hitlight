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
class Magegiant_Onestepcheckout_Model_Observer
{
    const CONVERT_ALGORITM_SOURCE_TARGET_WITH_PREFIX = 1;
    const CONVERT_ALGORITM_SOURCE_WITHOUT_PREFIX     = 2;
    const CONVERT_ALGORITM_TARGET_WITHOUT_PREFIX     = 3;

    const CONVERT_TYPE_CUSTOMER         = 'customer';
    const CONVERT_TYPE_CUSTOMER_ADDRESS = 'customer_address';

    public function controllerActionPredispatchCheckout($observer)
    {
        $controllerInstance = $observer->getControllerAction();
        if (
            $controllerInstance instanceof Mage_Checkout_OnepageController &&
            $controllerInstance->getRequest()->getActionName() !== 'success' &&
            $controllerInstance->getRequest()->getActionName() !== 'failure' &&
            $controllerInstance->getRequest()->getActionName() !== 'saveOrder' &&
            Mage::helper('onestepcheckout/config')->isEnabled()
        ) {
            $controllerInstance->getResponse()->setRedirect(
                Mage::getUrl('onestepcheckout/index', array('_secure' => true))
            );
            $controllerInstance->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);
        }
    }

    /**
     * @param $observer
     * submit order after
     */
    public function checkoutSubmitAllAfter($observer)
    {
        $oscOrderData = Mage::getSingleton('checkout/session')->getData('onestepcheckout_order_data');
        if (!is_array($oscOrderData)) {
            $oscOrderData = array();
        }
        // add customer comment
        if (array_key_exists('comments', $oscOrderData)) {
            $comment = $oscOrderData['comments'];
            if ($lastOrderId = Mage::getSingleton('checkout/type_onepage')->getCheckout()->getLastOrderId()) {
                $order = Mage::getModel('sales/order')->load($lastOrderId);
                $order
                    ->addStatusHistoryComment(Mage::helper('onestepcheckout')->__('Comment by customer: %s', $comment))
                    ->setIsVisibleOnFront(true)
                    ->save();
            }
        }
        // add delivery time
        if (array_key_exists('delivery', $oscOrderData) && !empty($oscOrderData['delivery'])) {
            $delivery_data = $oscOrderData['delivery'];
            if ($lastOrderId = Mage::getSingleton('checkout/type_onepage')->getCheckout()->getLastOrderId()) {
                $delivery = Mage::getModel('onestepcheckout/delivery');
                $delivery
                    ->setDeliveryTimeDate($delivery_data['date'] . ' ' . $delivery_data['time'])
                    ->setOrderId($lastOrderId)
                    ->save();
            }
        }
        // Add survey
        if (array_key_exists('onestepcheckout_survey_answer', $oscOrderData) && $oscOrderData['onestepcheckout_survey_answer']) {
            $survey_answer    = $oscOrderData['onestepcheckout_survey_answer'];
            $survey_quesition = $oscOrderData['onestepcheckout_survey_question'];
            if ($lastOrderId = Mage::getSingleton('checkout/type_onepage')->getCheckout()->getLastOrderId()) {
                $survey = Mage::getModel('onestepcheckout/survey');
                $survey
                    ->setQuestion($survey_quesition)
                    ->setAnswer($survey_answer)
                    ->setOrderId($lastOrderId)
                    ->save();
            }
        }
        // subscribe to newsletter
        if (array_key_exists('is_subscribed', $oscOrderData) && $oscOrderData['is_subscribed']) {
            $customer = Mage::getSingleton('customer/session')->getCustomer();
            if ($customer->getId()) {
                $data = array(
                    'email'       => $customer->getEmail(),
                    'first_name'  => $customer->getFirstname(),
                    'last_name'   => $customer->getLastname(),
                    'customer_id' => $customer->getId(),
                );
            } else {
                $billing = $oscOrderData['billing'];
                $data    = array(
                    'email'      => $billing['email'],
                    'first_name' => $billing['firstname'],
                    'last_name'  => $billing['lastname'],
                );
            }
            if (array_key_exists('segments_select', $oscOrderData)) {
                $data['segments_codes'] = $oscOrderData['segments_select'];
            }
            $data['store_id'] = Mage::app()->getStore()->getId();
            Mage::helper('onestepcheckout/newsletter')->subscribeCustomer($data);
        }

        //clear saved values
        Mage::getSingleton('checkout/session')->setData('onestepcheckout_form_values', array());
        Mage::getSingleton('checkout/session')->setData('onestepcheckout_order_data', array());
        Mage::getSingleton('checkout/session')->setData('is_used_giftwrap', '');
    }

    /**
     * Compatibility with Paypal Hosted Pro
     *
     * @param $observer
     */
    public function controllerActionPostdispatchOnestepcheckoutAjaxPlaceOrder($observer)
    {
        $paypalObserver = Mage::getModel('paypal/observer');
        if (!method_exists($paypalObserver, 'setResponseAfterSaveOrder')) {
            return $this;
        }
        $controllerAction = $observer->getEvent()->getControllerAction();
        $result           = Mage::helper('core')->jsonDecode(
            $controllerAction->getResponse()->getBody(),
            Zend_Json::TYPE_ARRAY
        );
        if ($result['success']) {
            $paypalObserver->setResponseAfterSaveOrder($observer);
            $result                  = Mage::helper('core')->jsonDecode(
                $controllerAction->getResponse()->getBody(),
                Zend_Json::TYPE_ARRAY
            );
            $result['is_hosted_pro'] = true;
            $controllerAction->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        }
    }

    /**
     * Change template for Authorize.net Direct Post (DPM)
     *
     * @param $observer
     */
    public function coreLayoutBlockCreateAfterOnestepcheckout($observer)
    {
        if (Mage::app()->getRequest()->getControllerModule() !== 'Magegiant_Onestepcheckout') {
            return $observer;
        }

        $block = $observer->getBlock();
        if ($block instanceof Mage_Authorizenet_Block_Directpost_Form) {
            $block->setTemplate('magegiant/onestepcheckout/onestep/form/payment/authorizenet/directpost.phtml');
        }
    }

    /**
     * Fix for bug in Mage_Core_Model_Layout_Update::getFileLayoutUpdatesXml
     *
     * @param $observer
     *
     * @todo Move to Magegiant_Lib
     */
    public function coreLayoutUpdateUpdatesGetAfter($observer)
    {
        /* @var Mage_Core_Model_Config_Element $updateRoot */
        $updateRoot       = $observer->getUpdates();
        $nodeListToRemove = array();
        foreach ($updateRoot->children() as $updateKey => $updateNode) {
            if ($updateNode->file) {
                if (strpos($updateKey, 'onestepcheckout') !== false) {
                    $module = $updateNode->getAttribute('module');
                    if ($module && !Mage::helper('core')->isModuleOutputEnabled($module)) {
                        $nodeListToRemove[] = $updateKey;
                    }
                }
            }
        }

        foreach ($nodeListToRemove as $nodeKey) {
            unset($updateRoot->$nodeKey);
        }
    }

    public function paypalPrepareLineItems($observer)
    {
        if ($paypalCart = $observer->getPaypalCart()) {
            $salesEntity        = $paypalCart->getSalesEntity();
            $giftWrapBaseAmount = $salesEntity->getGiantGiftwrapBaseAmount();
            if ($giftWrapBaseAmount > 0.0001) {
                $paypalCart->updateTotal(
                    Mage_Paypal_Model_Cart::TOTAL_SUBTOTAL,
                    (float)$giftWrapBaseAmount,
                    Mage::helper('onestepcheckout')->__('Gift wrap')
                );
            }
        }

        return $this;
    }

    public function salesQuoteAfterLoad(Varien_Event_Observer $observer)
    {
        $quote = $observer->getEvent()->getQuote();
        if ($quote instanceof Mage_Core_Model_Abstract) {
            Mage::getModel('onestepcheckout/sales_quote')
                ->load($quote->getId())
                ->attachAttributeData($quote);
        }

        return $this;
    }

    public function salesQuoteAddressCollectionAfterLoad(Varien_Event_Observer $observer)
    {
        $collection = $observer->getEvent()->getQuoteAddressCollection();
        if ($collection instanceof Varien_Data_Collection_Db) {
            Mage::getModel('onestepcheckout/sales_quote_address')
                ->attachDataToCollection($collection);
        }

        return $this;
    }

    public function salesQuoteAfterSave(Varien_Event_Observer $observer)
    {
        $quote = $observer->getEvent()->getQuote();
        if ($quote instanceof Mage_Core_Model_Abstract) {
            Mage::getModel('onestepcheckout/sales_quote')
                ->saveAttributeData($quote);
        }

        return $this;
    }

    public function salesQuoteAddressAfterSave(Varien_Event_Observer $observer)
    {
        $quoteAddress = $observer->getEvent()->getQuoteAddress();
        if ($quoteAddress instanceof Mage_Core_Model_Abstract) {
            Mage::getModel('onestepcheckout/sales_quote_address')
                ->saveAttributeData($quoteAddress);
        }

        return $this;
    }

    public function salesOrderAfterLoad(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        if ($order instanceof Mage_Core_Model_Abstract) {
            Mage::getModel('onestepcheckout/sales_order')
                ->load($order->getId())
                ->attachAttributeData($order);
        }

        return $this;
    }

    public function salesOrderAddressCollectionAfterLoad(Varien_Event_Observer $observer)
    {
        $collection = $observer->getEvent()->getOrderAddressCollection();
        if ($collection instanceof Varien_Data_Collection_Db) {
            Mage::getModel('onestepcheckout/sales_order_address')
                ->attachDataToCollection($collection);
        }

        return $this;
    }

    public function salesOrderAfterSave(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        if ($order instanceof Mage_Core_Model_Abstract) {
            Mage::getModel('onestepcheckout/sales_order')
                ->saveAttributeData($order);
        }

        return $this;
    }

    public function salesOrderAddressAfterSave(Varien_Event_Observer $observer)
    {
        $orderAddress = $observer->getEvent()->getAddress();
        if ($orderAddress instanceof Mage_Core_Model_Abstract) {
            Mage::getModel('onestepcheckout/sales_order_address')
                ->saveAttributeData($orderAddress);
        }

        return $this;
    }

    /**
     * Observer for converting quote to order
     *
     * @param Varien_Event_Observer $observer
     * @return Magegiant_Onestepcheckout_Model_Observer
     */
    public function coreCopyFieldsetSalesConvertQuoteToOrder(Varien_Event_Observer $observer)
    {
        $this->_copyFieldset(
            $observer,
            self::CONVERT_ALGORITM_SOURCE_TARGET_WITH_PREFIX,
            self::CONVERT_TYPE_CUSTOMER
        );

        return $this;
    }

    /**
     * Observer for converting quote address to order address
     *
     * @param Varien_Event_Observer $observer
     * @return Magegiant_Onestepcheckout_Model_Observer
     */
    public function coreCopyFieldsetSalesConvertQuoteAddressToOrderAddress(Varien_Event_Observer $observer)
    {
        $this->_copyFieldset(
            $observer,
            self::CONVERT_ALGORITM_SOURCE_TARGET_WITH_PREFIX,
            self::CONVERT_TYPE_CUSTOMER_ADDRESS
        );

        return $this;
    }

    /**
     * Observer for converting order to quote
     *
     * @param Varien_Event_Observer $observer
     * @return Magegiant_Onestepcheckout_Model_Observer
     */
    public function coreCopyFieldsetSalesCopyOrderToEdit(Varien_Event_Observer $observer)
    {
        $this->_copyFieldset(
            $observer,
            self::CONVERT_ALGORITM_SOURCE_TARGET_WITH_PREFIX,
            self::CONVERT_TYPE_CUSTOMER
        );

        return $this;
    }

    /**
     * Observer for converting order billing address to quote billing address
     *
     * @param Varien_Event_Observer $observer
     * @return Magegiant_Onestepcheckout_Model_Observer
     */
    public function coreCopyFieldsetSalesCopyOrderBillingAddressToOrder(Varien_Event_Observer $observer)
    {
        $this->_copyFieldset(
            $observer,
            self::CONVERT_ALGORITM_SOURCE_TARGET_WITH_PREFIX,
            self::CONVERT_TYPE_CUSTOMER_ADDRESS
        );

        return $this;
    }

    /**
     * Observer for converting order shipping address to quote shipping address
     *
     * @param Varien_Event_Observer $observer
     * @return Magegiant_Onestepcheckout_Model_Observer
     */
    public function coreCopyFieldsetSalesCopyOrderShippingAddressToOrder(Varien_Event_Observer $observer)
    {
        $this->_copyFieldset(
            $observer,
            self::CONVERT_ALGORITM_SOURCE_TARGET_WITH_PREFIX,
            self::CONVERT_TYPE_CUSTOMER_ADDRESS
        );

        return $this;
    }

    /**
     * Observer for converting customer to quote
     *
     * @param Varien_Event_Observer $observer
     * @return Magegiant_Onestepcheckout_Model_Observer
     */
    public function coreCopyFieldsetCustomerAccountToQuote(Varien_Event_Observer $observer)
    {
        $this->_copyFieldset(
            $observer,
            self::CONVERT_ALGORITM_SOURCE_WITHOUT_PREFIX,
            self::CONVERT_TYPE_CUSTOMER
        );

        return $this;
    }

    /**
     * Observer for converting customer address to quote address
     *
     * @param Varien_Event_Observer $observer
     * @return Magegiant_Onestepcheckout_Model_Observer
     */
    public function coreCopyFieldsetCustomerAddressToQuoteAddress(Varien_Event_Observer $observer)
    {
        $this->_copyFieldset(
            $observer,
            self::CONVERT_ALGORITM_SOURCE_WITHOUT_PREFIX,
            self::CONVERT_TYPE_CUSTOMER_ADDRESS
        );

        return $this;
    }

    /**
     * Observer for converting quote address to customer address
     *
     * @param Varien_Event_Observer $observer
     * @return Magegiant_Onestepcheckout_Model_Observer
     */
    public function coreCopyFieldsetQuoteAddressToCustomerAddress(Varien_Event_Observer $observer)
    {
        $this->_copyFieldset(
            $observer,
            self::CONVERT_ALGORITM_SOURCE_WITHOUT_PREFIX,
            self::CONVERT_TYPE_CUSTOMER_ADDRESS
        );

        return $this;
    }

    /**
     * Observer for converting quote to customer
     *
     * @param Varien_Event_Observer $observer
     * @return Magegiant_Onestepcheckout_Model_Observer
     */
    public function coreCopyFieldsetCheckoutOnepageQuoteToCustomer(Varien_Event_Observer $observer)
    {
        $this->_copyFieldset(
            $observer,
            self::CONVERT_ALGORITM_TARGET_WITHOUT_PREFIX,
            self::CONVERT_TYPE_CUSTOMER
        );

        return $this;
    }

    protected function _copyFieldset(Varien_Event_Observer $observer, $algoritm, $convertType)
    {
        $source = $observer->getEvent()->getSource();
        $target = $observer->getEvent()->getTarget();

        if ($source instanceof Mage_Core_Model_Abstract && $target instanceof Mage_Core_Model_Abstract) {
            if ($convertType == self::CONVERT_TYPE_CUSTOMER) {
                $attributes = Mage::helper('onestepcheckout')->getCustomerUserDefinedAttributeCodes();
                $prefix     = 'customer_';
            } else if ($convertType == self::CONVERT_TYPE_CUSTOMER_ADDRESS) {
                $attributes = Mage::helper('onestepcheckout')->getCustomerAddressUserDefinedAttributeCodes();
                $prefix     = '';
            } else {
                return $this;
            }

            foreach ($attributes as $attribute) {
                switch ($algoritm) {
                    case self::CONVERT_ALGORITM_SOURCE_TARGET_WITH_PREFIX:
                        $sourceAttribute = $prefix . $attribute;
                        $targetAttribute = $prefix . $attribute;
                        break;
                    case self::CONVERT_ALGORITM_SOURCE_WITHOUT_PREFIX:
                        $sourceAttribute = $attribute;
                        $targetAttribute = $prefix . $attribute;
                        break;
                    case self::CONVERT_ALGORITM_TARGET_WITHOUT_PREFIX:
                        $sourceAttribute = $prefix . $attribute;
                        $targetAttribute = $attribute;
                        break;
                    default:
                        return $this;
                }
                $target->setData($targetAttribute, $source->getData($sourceAttribute));
            }
        }

        return $this;
    }
}