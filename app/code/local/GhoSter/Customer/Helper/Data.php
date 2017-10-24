<?php
class GhoSter_Customer_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getFlashlights() {
        $flashlights = Mage::getStoreConfig('use_type_customer/flashlights/flashlight');
        $arrFlashlights = array();

        if($flashlights) {
            $flashlights = unserialize($flashlights);
            if (is_array($flashlights)) {
                foreach($flashlights as $flashlight) {
                    $arrFlashlights[$flashlight['flashlight_subtotal_price']] = $flashlight['flashlight_product_sku'];
                }
            }
        }

        return $arrFlashlights;
    }

    public function addItemFlashlights() {
        $arrFlashlights = $this->getFlashlights();

        $result = 0;
        if($arrFlashlights) {
            $cart = Mage::getSingleton('checkout/cart');
            $storeId = Mage::app()->getStore()->getId();

            $quoteObj = $cart->getQuote();
            $quoteObj->setStore(Mage::getSingleton('core/store')->load($storeId));

            $totalQuote = $quoteObj->getGrandTotal();

            ksort($arrFlashlights);

            $skuProduct = '';

            foreach($arrFlashlights as $key => $arrFlashlight) {
                if($totalQuote > $key) {
                    $skuProduct = $arrFlashlight;
                }
            }

            if($skuProduct) {
                $addProduct = false;
                $quoteProducts = $quoteObj->getAllItems();

                foreach ($quoteProducts as $quoteProduct) {
                    if($quoteProduct->getPrice() == 0 && in_array($quoteProduct->getSku(), $arrFlashlights)) {
                        $addProduct = true;
                        break;
                    }
                }

                if(!$addProduct) {
                    $product = Mage::getModel('catalog/product');
                    $product->load($product->getIdBySku($skuProduct));

                    $quoteItem = Mage::getModel('sales/quote_item')->setProduct($product);
                    $quoteItem->setQuote($quoteObj);
                    $quoteItem->setQty('1');
                    $quoteItem->setStoreId($storeId);
                    $quoteItem->setCustomPrice(0);
                    $quoteItem->setOriginalCustomPrice(0);
                    $quoteObj->addItem($quoteItem);
                    $quoteObj->setStoreId($storeId);
                    $quoteObj->collectTotals();
                    $quoteObj->save();
                    $result = 1;
                }
            } else {
                $itemId = '';
                $quoteProducts = $quoteObj->getAllItems();

                foreach ($quoteProducts as $quoteProduct) {
                    if($quoteProduct->getPrice() == 0 && in_array($quoteProduct->getSku(), $arrFlashlights)) {
                        $itemId = $quoteProduct->getId();
                        break;
                    }
                }

                if($itemId) {
                    $quoteObj->removeItem($itemId);
                    $quoteObj->save();
                    $result = -1;
                }
            }
        }
        return $result;
    }
}