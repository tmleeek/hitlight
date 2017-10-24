<?php


class Hil_Downloader_Block_Adminhtml_Downloader extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{
	$this->_controller = "adminhtml_downloader";
	$this->_blockGroup = "downloader";
	$this->_headerText = Mage::helper("downloader")->__("Manage Ebook download");
//	$this->_addButtonLabel = Mage::helper("downloader")->__("Add New Item");
	parent::__construct();
	
	}

}