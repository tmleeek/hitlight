<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/11/16
 * Time: 10:45 AM
 */
class GhoSter_ShopByProject_Block_Adminhtml_Project_Edit_Tabs_Slide extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('slider_fieldset', array(
            'legend' => Mage::helper('ghoster_shopbyproject')->__('Applications Banner')
        ));
        $fieldset->addField('slider_images', 'text', array(
            'label' => Mage::helper('ghoster_shopbyproject')->__('Banners')
        ));
        $form->getElement('slider_images')->setRenderer(
            $this->getLayout()->createBlock('ghoster_shopbyproject/adminhtml_widget_form_element_images')
                ->setData('banner', Mage::registry('current_project'))
        );

        if (Mage::getSingleton("adminhtml/session")->getProjectData()) {
            $form->setValues(Mage::getSingleton("adminhtml/session")->getProjectData());
            Mage::getSingleton("adminhtml/session")->setProjectData(null);
        } elseif (Mage::registry("current_project")) {
            $form->setValues(Mage::registry("current_project")->getData());
        }
        $this->setForm($form);
    }
}
