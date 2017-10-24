<?php
class GhoSter_ShopByProject_Block_Adminhtml_Generator_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("generator_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("ghoster_shopbyproject")->__("Instruction Block Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("ghoster_shopbyproject")->__("Instruction Block Information"),
				"title" => Mage::helper("ghoster_shopbyproject")->__("Instruction Block Information"),
				"content" => $this->getLayout()->createBlock("ghoster_shopbyproject/adminhtml_generator_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
