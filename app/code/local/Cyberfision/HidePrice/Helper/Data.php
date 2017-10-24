<?php
/**
 * Created by PhpStorm.
 * User: doanns
 * Date: 22/09/2016
 * Time: 11:03
 */ 
class Cyberfision_HidePrice_Helper_Data extends Mage_Core_Helper_Abstract {

    public function isAllow(){
        $status = false;
        $storeAllow = explode(',', Mage::getStoreConfig('wholesale/general/wholesale_type_store'));
        $customerGroupIsWholesale = Mage::getStoreConfig('wholesale/general/wholesale_customer_group');
        $currentStore = Mage::app()->getStore()->getId();
        if(in_array($currentStore, $storeAllow) ){
            if(Mage::getSingleton('customer/session')->isLoggedIn()){
                $customer = Mage::getSingleton('customer/session')->getCustomer();
                if($customer->getGroupId()==$customerGroupIsWholesale){
                    $status = true;
                }
            }
        }else{
            $status = true;
        }
        return $status;
    }
}