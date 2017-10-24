<?php
	
class Hil_Downloader_Block_Adminhtml_Downloader_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "id";
				$this->_blockGroup = "downloader";
				$this->_controller = "adminhtml_downloader";
				$this->_updateButton("save", "label", Mage::helper("downloader")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("downloader")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("slider")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);



				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
//				if( Mage::registry("downloader_data") && Mage::registry("downloader_data")->getId() ){
//
//				    return Mage::helper("downloader")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("downloader_data")->getId()));
//
//				}
//				else{
//
//				     return Mage::helper("downloader")->__("Add Item");
//
//				}
		}
}