<?php 
class Imedia_Quickview_IndexController extends Mage_Core_Controller_Front_Action{
    
	public function indexAction(){
        $productid = Mage::app()->getRequest()->getParam('id');
        $_product  = Mage::getModel('catalog/product')->load($productid);
        Mage::register('product', $_product);
		echo $this->getLayout()->createBlock('core/template')->setTemplate('imedia/quickview/view.phtml')->toHtml();  
    
	}
	
}
?>