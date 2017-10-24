<?php
class NextBits_Wholesale_CustomerController extends Mage_Core_Controller_Front_Action{
	public function indexAction(){
		$this->loadLayout();
		$this->renderLayout();
	}
    protected function _getSession()
    {
        return Mage::getSingleton('customer/session');
    }

	public function formAction()
	{
        if ($this->_getSession()->isLoggedIn()) {
            $this->_redirect('*/*/');
            return;
        }
        $this->getResponse()->setHeader('Login-Required', 'true');
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        $this->renderLayout();
	}
}