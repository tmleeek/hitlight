<?php

class GhoSter_CategorySlider_Block_Adminhtml_Catalog_Category_Tab_Slider extends Mage_Adminhtml_Block_Catalog_Form{

    protected function _prepareLayout(){
        parent::_prepareLayout();

        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('slider_fieldset', array(
            'legend' => Mage::helper('ghoster_categoryslider')->__('Slider Information')
        ));
        $fieldset->addField('slider_images', 'text', array(
            'label' => Mage::helper('ghoster_categoryslider')->__('Images')
        ));

        $form->getElement('slider_images')->setRenderer(
            $this->getLayout()->createBlock('ghoster_categoryslider/adminhtml_widget_form_element_images')
                ->setData('category', Mage::registry('category'))
        );

        $this->setForm($form);
    }
}