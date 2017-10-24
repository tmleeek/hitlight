<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/1/16
 * Time: 3:42 PM
 */
class GhoSter_ShopByProject_Block_Adminhtml_Project_Edit_Tabs_Commonproduct extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {

        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('common_form', array('legend' => Mage::helper('ghoster_shopbyproject')->__('Project Information')));

        $common_field = $fieldset->addField('products', 'multiselect', array(
            'label' => Mage::helper('ghoster_shopbyproject')->__('Select Common Products'),
            'class' => 'common-products',
            'name' => 'products',
            'values' => '',
        ));

        // Ajax Auto Load Common Products
        if(Mage::registry('current_project')->getData()) {
            $common_field->setAfterElementHtml("<script type=\"text/javascript\">
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
