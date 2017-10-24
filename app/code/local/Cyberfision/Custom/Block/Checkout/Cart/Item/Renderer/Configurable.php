<?php
/**
 * Created by PhpStorm.
 * User: doanns
 * Date: 09/12/2016
 * Time: 14:50
 */ 
class Cyberfision_Custom_Block_Checkout_Cart_Item_Renderer_Configurable extends Mage_Checkout_Block_Cart_Item_Renderer_Configurable {
    /**
     * Get item product name
     *
     * @return string
     */
    public function getProductName()
    {
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        return $read->fetchOne('select name from sales_flat_quote_item where parent_item_id=?', array($this->getItem()->getId()));
        //return $this->getProduct()->getName();
    }
}