<?php
require_once ('Mage/Sales/controllers/GuestController.php');
class Customs_Register_GuestController extends Mage_Sales_GuestController
{
    public function formAction()
    {
//        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
//            $this->_redirect('customer/account/');
//            return;
//        }
        $this->loadLayout();
        Mage::helper('sales/guest')->getBreadcrumbs($this);
        $this->renderLayout();
    }
}
?>