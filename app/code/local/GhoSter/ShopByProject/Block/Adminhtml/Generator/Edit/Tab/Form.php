<?php

class GhoSter_ShopByProject_Block_Adminhtml_Generator_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset("shopbyproject_form", array("legend" => Mage::helper("ghoster_shopbyproject")->__("Instruction Block information")));


        $fieldset->addField("title", "text", array(
            "label" => Mage::helper("ghoster_shopbyproject")->__("Instruction Block Title"),
            "name" => "title",
            'class' => 'required-entry',
            'required' => true,
        ));

        $fieldset->addField("identifier", "text", array(
            "label" => Mage::helper("ghoster_shopbyproject")->__("Identifier"),
            "name" => "identifier",
            'class' => 'required-entry',
            'required' => true,
        ));

        $fieldset->addField('instruction_step', 'text', array(
            'label' => Mage::helper('ghoster_shopbyproject')->__('Instruction Steps'),
            'class' => 'required-entry',
            'required' => true,
        ));

        $form->getElement('instruction_step')->setRenderer(
            $this->getLayout()->createBlock('ghoster_shopbyproject/adminhtml_widget_form_element_step')
                ->setData('instruction', Mage::registry('generator_data'))
        );


        if (Mage::getSingleton("adminhtml/session")->getGeneratorData()) {
            $form->setValues(Mage::getSingleton("adminhtml/session")->getGeneratorData());
            Mage::getSingleton("adminhtml/session")->setGeneratorData(null);
        } elseif (Mage::registry("generator_data")) {
            $form->setValues(Mage::registry("generator_data")->getData());
        }
        return parent::_prepareForm();
    }
}
