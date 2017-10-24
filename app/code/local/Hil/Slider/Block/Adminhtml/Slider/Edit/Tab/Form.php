<?php

class Hil_Slider_Block_Adminhtml_Slider_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset("slider_form", array("legend" => Mage::helper("slider")->__("Item information")));


        $fieldset->addField('banner_image', 'image', array(
            'label' => Mage::helper('slider')->__('Image'),
            'name' => 'banner_image',
            'note' => '(*.jpg, *.png, *.gif)',
            'required' => true
        ));
        $fieldset->addField("url_banner", "text", array(
            "label" => Mage::helper("slider")->__("Url Banner"),
            "name" => "url_banner",
            'required' => true
        ));

        $fieldset->addField("desc_banner", "textarea", array(
            "label" => Mage::helper("slider")->__("Description Banner"),
            "name" => "desc_banner",
            'required' => true
        ));

        $fieldset->addField("url_ebook", "text", array(
            "label" => Mage::helper("slider")->__("Link e-Book"),
            "name" => "url_ebook",
            'required' => true
        ));

        $fieldset->addField("desc_ebook", "textarea", array(
            "label" => Mage::helper("slider")->__("Description e-Book"),
            "name" => "desc_ebook",
            'required' => true
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('slider')->__('Enable'),
            'values' => Hil_Slider_Block_Adminhtml_Slider_Grid::getValueArray5(),
            'name' => 'status',
        ));
        $dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(
            Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
        );

        if (Mage::getSingleton("adminhtml/session")->getSliderData()) {
            $form->setValues(Mage::getSingleton("adminhtml/session")->getSliderData());
            Mage::getSingleton("adminhtml/session")->setSliderData(null);
        } elseif (Mage::registry("slider_data")) {
            $form->setValues(Mage::registry("slider_data")->getData());
        }
        return parent::_prepareForm();
    }
}
