<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 14/07/2016
 * Time: 14:22
 */
class GhoSter_ShopByProject_Helper_Shopallproducts extends Mage_Core_Helper_Abstract
{
    /**
     * @param $project_id
     * @param $category_id
     * @return GhoSter_ShopByProject_Model_Resource_Shopallproducts_Collection
     */
    public function getShopAllProducts($project_id, $category_id)
    {

        $sbp_products = Mage::getModel('ghoster_shopbyproject/shopallproducts')->getCollection()
            ->addFieldToSelect("*")
            ->addFieldToFilter('project_id', $project_id)
            ->addFieldToFilter('entity_id', $category_id);
            //echo "<pre>"; var_dump($sbp_products->getData()); die;
        return $sbp_products;
    }

    /**
     *
     * @param $string
     * @return array
     */
    public function getProductSkus($string)
    {
        $string = str_replace(' ', '', $string);
        return explode(',', $string);
    }

    /**
     * @param $_sku
     * @return Mage_Catalog_Model_Product
     */
    public function getProduct($_sku)
    {
        return Mage::getModel('catalog/product')->loadByAttribute('sku', $_sku);
    }


    /**
     * Get Shop All Products Price
     *
     * @param $product_skus |array
     * @return float|int
     */
    public function getShopAllProductsPrice($product_skus)
    {
        $total_price = 0;

        foreach ($product_skus as $product_sku) {
            if($product = $this->getProduct($product_sku)){
                if($product->getTypeId() == "simple") {
                    $total_price += $product->getFinalPrice();
                }
            }
            
        }

        return $total_price;
    }


    public function getShopAllProductsLink($product_ids)
    {
        return Mage::getUrl('shopbyproject/project/multipleProdAdd', array('product_ids' => $product_ids));
    }

}
