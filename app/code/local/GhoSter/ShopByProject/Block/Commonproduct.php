<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/18/16
 * Time: 10:47 AM
 */
class GhoSter_ShopByProject_Block_Commonproduct extends Mage_Core_Block_Template
{
    public function getCommonProducts()
    {
        $common_products = Mage::getModel('ghoster_shopbyproject/commonproduct')->getCollection()
            ->addFieldToSelect("*")
            ->setPageSize(12)
            ->setCurPage(1);

        $common_products->getSelect()->order(new Zend_Db_Expr('RAND()'));

        return $common_products;
    }

}
