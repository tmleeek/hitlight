<?php
class Cyberfision_Brandshow_Block_Catalog_Product_View_Link extends Mage_Core_Block_Template
{
    public function getBrand()
    {
        $product = Mage::registry('current_product');
        if (!$product instanceof Mage_Catalog_Model_Product) {
            return false;
        }
        
        $brandId = (int)$product->getBrandId();
        $brand = Mage::getModel('cyberfision_brand/brand')->load($brandId);
        if ($brand->getId() < 1) {
            return false;
        }
        
        return $brand;
    }
}