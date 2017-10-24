<?php

class GhoSter_ShopByProject_Block_Adminhtml_Generator_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {

        parent::__construct();
        $this->_objectId = "ud";
        $this->_blockGroup = "ghoster_shopbyproject";
        $this->_controller = "adminhtml_generator";
        $this->_updateButton("save", "label", Mage::helper("ghoster_shopbyproject")->__("Save Instruction Block"));
        $this->_updateButton("delete", "label", Mage::helper("ghoster_shopbyproject")->__("Delete Instruction Block"));

        $this->_addButton("saveandcontinue", array(
            "label" => Mage::helper("ghoster_shopbyproject")->__("Save And Continue Edit"),
            "onclick" => "saveAndContinueEdit()",
            "class" => "save",
        ), -100);


        $this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
    }

    public function getHeaderText()
    {
        if (Mage::registry("generator_data") && Mage::registry("generator_data")->getId()) {

            return Mage::helper("ghoster_shopbyproject")->__("Edit Instruction Block '%s'", $this->htmlEscape(Mage::registry("generator_data")->getId()));

        } else {

            return Mage::helper("ghoster_shopbyproject")->__("Add Instruction Block");

        }
    }
}