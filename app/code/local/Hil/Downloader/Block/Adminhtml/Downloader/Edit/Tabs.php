<?php
class Hil_Downloader_Block_Adminhtml_Downloader_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("downloader_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("downloader")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("downloader")->__("Item Information"),
				"title" => Mage::helper("downloader")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("downloader/adminhtml_downloader_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
