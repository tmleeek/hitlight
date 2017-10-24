<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/29/16
 * Time: 1:44 PM
 */
class GhoSter_ShopByProject_Block_Adminhtml_Project_Edit_Tabs_Description extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {

        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('description_form', array('legend' => Mage::helper('ghoster_shopbyproject')->__('Description Information')));

        $desc_field = $fieldset->addField('how_to', 'textarea', array(
            'label' => Mage::helper('ghoster_shopbyproject')->__('Description Information'),
            'class' => 'description',
            'name' => 'how_to',
            'values' => '',
        ));


        $fieldset->addField('summary', 'textarea', array(
            'label' => Mage::helper('ghoster_shopbyproject')->__('Summary'),
            'name' => 'summary',
            'values' => '',
        ));

        $fieldset->addField('instruction_block', 'select', array(
            'label' => Mage::helper('ghoster_shopbyproject')->__('Select Instruction Block'),
            'name' => 'instruction_block',
            'onclick' => "",
            'onchange' => "",
            'options' => Mage::helper('ghoster_shopbyproject')->getInstructionCMSBlocksOptionArray(),
        ));

        // Ajax Auto Load Common Products
        if (Mage::registry('current_project')->getData()) {
            $desc_field->setAfterElementHtml("<script type=\"text/javascript\">
            document.observe(\"dom:loaded\", function() {
                var selectElement = document.getElementById('categories');
                getCategoriesTab(selectElement);
            });
        </script>");
        }

        if (Mage::getSingleton('adminhtml/session')->getProjectData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getProjectData());
            Mage::getSingleton('adminhtml/session')->setProjectData(null);
        } elseif (Mage::registry('current_project')) {
            $form->setValues(Mage::registry('current_project')->getData());
        }

        $this->setForm($form);
        return parent::_prepareForm();
    }
}
