<?php
class Customs_Register_Model_Observer {
/*
    public function catalogProductSaveAfter(Varien_Event_Observer $observer)
    {
        $product = $observer->getProduct();
        // get include params
        $productId = Mage::app()->getRequest()->getParam('id');
        $storeId = Mage::app()->getRequest()->getParam('store');
        $productDataPost = Mage::app()->getRequest()->getParam('product'); // special_price

        // check store
        $storeIdUpdate = 0;
        if ($storeId) {
            $storeIdUpdate = $storeId;
        }
        if ($storeIdUpdate != 0) {
            $read_connection = Mage::getSingleton('core/resource')->getConnection('core_read');
            $query_data="select * from catalog_product_entity_decimal where entity_type_id=4 and attribute_id =70 and entity_id=$productId";
            $rowsArray = $read_connection->fetchAll($query_data);
        }

        echo "<pre>"; var_dump($productId, $storeId, $productDataPost); die;
    }
*/

    public function customerLogin(Varien_Event_Observer $observer)
    {
        $customerEmail = Mage::app()->getRequest()->getPost('login')['username'];
        //echo $customerEmail;
        $customer = Mage::getModel("customer/customer");
        $customer->setWebsiteId(Mage::app()->getWebsite()->getId());
        $customer->loadByEmail($customerEmail);

        // wholesale
        // create Mage::app()->getRequest()->getParams('customer_store_create') ;
        if ($customer->getStoreId()== 3) { //Commercials
            $url = Mage::getBaseUrl().'?___store=wholesale&amp;___from_store=wholesale';
            header("Location: $url");
            exit();
        }
        /*
        else {
            $url = Mage::getBaseUrl().'?___store=default&___from_store=wholesale';
            header("Location: $url");
            exit();
        }
        */
    }

    public function customerLogout(Varien_Event_Observer $observer)
    {

        $customerGroupId = Mage::getSingleton('customer/session');
        $gId = $customerGroupId->getCustomer()->getStoreId();
        if ($gId == 3) { // Commercials
            $url = Mage::getBaseUrl().'?___store=default&amp;___from_store=default';
            header("Location: $url");
            exit();
        }
        /*
        else {
            $url = Mage::getBaseUrl().'?___store=default&___from_store=wholesale';
            header("Location: $url");
            exit();
        }
        */
    }
}
?>