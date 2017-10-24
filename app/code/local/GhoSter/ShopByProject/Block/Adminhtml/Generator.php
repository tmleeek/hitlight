<?php


class GhoSter_ShopByProject_Block_Adminhtml_Generator extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_generator";
	$this->_blockGroup = "ghoster_shopbyproject";
	$this->_headerText = Mage::helper("ghoster_shopbyproject")->__("Instruction CMS Blocks Generator");
	$this->_addButtonLabel = Mage::helper("ghoster_shopbyproject")->__("Add New Instruction Block");
	parent::__construct();
	
	}

}