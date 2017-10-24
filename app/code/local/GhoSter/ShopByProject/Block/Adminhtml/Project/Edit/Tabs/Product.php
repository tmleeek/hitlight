<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/11/16
 * Time: 2:08 PM
 */
class GhoSter_ShopByProject_Block_Adminhtml_Project_Edit_Tabs_Product extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset("shop_all_product", array("legend" => Mage::helper("ghoster_shopbyproject")->__("Shop All Products")));


        $fieldset->addField("products", "textarea", array(
            "label" => Mage::helper("ghoster_shopbyproject")->__("Products SKU"),
            "class" => "products",
            "name" => "products",
            'note' => "Enter Product SKU seperated by comma \"<b>,</b>\" ex: 176456,83453,25223"
        ));


        if (Mage::getSingleton("adminhtml/session")->getProjectData()) {
            $form->setValues(Mage::getSingleton("adminhtml/session")->getProjectData());
            Mage::getSingleton("adminhtml/session")->setProjectData(null);
        } elseif (Mage::registry("current_project")) {
            $form->setValues(Mage::registry("current_project")->getData());
        }
        return parent::_prepareForm();
    }
}
