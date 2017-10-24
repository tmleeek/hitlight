<?php
/**
 * Created by PhpStorm.
 * User: magento
 * Date: 25/11/2016
 * Time: 16:05
 */
class Cyberfision_Custom_Model_Observer
{
    const XML_PATH_EMAIL_RECIPIENT  = 'cyberfision_custom/reorder/recipient_email';
    const XML_PATH_EMAIL_SENDER     = 'cyberfision_custom/reorder/sender_email_identity';
    const XML_PATH_EMAIL_TEMPLATE   = 'cyberfision_custom/reorder/email_template';

    public function sendMailReorder(){
        $id = Mage::app()->getRequest()->getParam('order_id');
        if(isset($id) && $id!==null){
            $order = Mage::getModel('sales/order')->load($id);
            /* @var Mage_Sales_Model_Order $order */
            if($order->getId()){
                $translate = Mage::getSingleton('core/translate');
                /* @var $translate Mage_Core_Model_Translate */
                $translate->setTranslateInline(false);
                try {
                    $postObject = new Varien_Object();
                    $post = array(
                        'name'=> $order->getCustomerName(),
                        'orderNumber' => $order->getIncrementId(),
                        'email' => $order->getCustomerEmail(),
                        'reason' => Mage::app()->getRequest()->getPost('oar_reason')
                    );
                    $postObject->setData($post);


                    $mailTemplate = Mage::getModel('core/email_template');
                    /* @var $mailTemplate Mage_Core_Model_Email_Template */
                    $mailTemplate->setDesignConfig(array('area' => 'frontend'))
                        ->sendTransactional(
                            Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE),
                            Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
                            Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT),
                            null,
                            array('data' => $postObject)
                        );

                    if (!$mailTemplate->getSentSuccess()) {
                        throw new Exception();
                    }

                    $translate->setTranslateInline(true);


                    return;
                } catch (Exception $e) {
                    $translate->setTranslateInline(true);

                    return;
                }
            }
        }


    }


    public function setQuoteItemPrice($obeserver){
        // Get the quote item
        $item = $obeserver->getQuoteItem();
        // Ensure we have the parent item, if it has one

        Mage::log($item->getProduct()->getId(),null, 'doan.log');
        $productId = $item->getProduct()->getId();

        if($item =  $item->getParentItem()){
            // Load the custom price

            $product = Mage::getModel('catalog/product')->load($productId);
            $price = $product->getFinalPrice($item->getQty());
            // Set the custom price
            $item->setCustomPrice($price);
            $item->setOriginalCustomPrice($price);
            // Enable super mode on the product.
            $item->getProduct()->setIsSuperMode(true);
        }

    }

    protected function calculateSpecialPrice($finalPrice, $specialPrice, $specialPriceFrom, $specialPriceTo,
                                             $store = null)
    {
        if (!is_null($specialPrice) && $specialPrice != false) {
            if (Mage::app()->getLocale()->isStoreDateInInterval($store, $specialPriceFrom, $specialPriceTo)) {
                $finalPrice     = min($finalPrice, $specialPrice);
            }
        }
        return $finalPrice;
    }
}