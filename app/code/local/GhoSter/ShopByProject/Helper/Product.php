<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/18/16
 * Time: 5:13 PM
 */
class GhoSter_ShopByProject_Helper_Product extends Mage_Core_Helper_Abstract
{

    CONST MAX_NAME_LENGTH = 24;

    /**
     * Load Product Model From Product Id
     *
     * @param $_product_id
     * @return Mage_Core_Model_Abstract
     */

    public function getProduct($_product_id)
    {
        $product = Mage::getModel('catalog/product')->load($_product_id);
        return $product;

    }


    /**
     * Substring Common Product Name
     *
     * @param $product
     * @return mixed|string
     */
    public function getCommonProductName($product)
    {
        /* @var $product Mage_Catalog_Model_Product */
        if(strlen($product->getName()) > GhoSter_ShopByProject_Helper_Product::MAX_NAME_LENGTH) {
            return mb_substr($this->escapeHtml($product->getName()), 0, GhoSter_ShopByProject_Helper_Product::MAX_NAME_LENGTH) . '...';
        }

        return $this->escapeHtml($product->getName());
    }
}
