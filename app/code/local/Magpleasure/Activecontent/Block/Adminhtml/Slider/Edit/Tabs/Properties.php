<?php
/**
 * MagPleasure Ltd.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE-CE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magpleasure.com/LICENSE-CE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento COMMUNITY edition
 * MagPleasure does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * Magpleasure does not provide extension support in case of
 * incorrect edition usage.
 * =================================================================
 *
 * @category   MagPleasure
 * @package    Magpleasure_Forms
 * @version    1.1.3
 * @copyright  Copyright (c) 2011-2014 MagPleasure Ltd. (http://www.magpleasure.com)
 * @license    http://www.magpleasure.com/LICENSE-CE.txt
 */

class Magpleasure_Activecontent_Block_Adminhtml_Slider_Edit_Tabs_Properties extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Form Helper
     *
     * @return Magpleasure_Activecontent_Helper_Data
     */
    protected function _helper()
    {
        return Mage::helper('activecontent');
    }

    protected function _getTabDefaults()
    {
        return array(
            'type' => 'horizontal',
            'easing' => 'swing',
            'controls' => 'horizontal',
            'pager' => '1',
            'autohide' => '1',
            'ticker' => '0',
            'slideshow' => '1',
            'duration' => '500',
            'ticker_speed' => '5000',
            'slideshow_pause' => '5000',
        );
    }

    /**
     * Prepare form before rendering HTML
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('properties_fieldset', array('legend'=>$this->_helper()->__('Slider Properties')));

        /** @var Magpleasure_Activecontent_Model_Block_Type $types  */
        $types = Mage::getSingleton('activecontent/block_type');
        $fieldset->addField('type', 'select', array(
            'label'     => $this->_helper()->__('Type'),
            'required'  => false,
            'name'      => 'type',
            'options'   => $types->getOptionArray(),
        ));

        /** @var Magpleasure_Activecontent_Model_Block_Easing $types  */
        $easing = Mage::getSingleton('activecontent/block_easing');
        $fieldset->addField('easing', 'select', array(
            'label'     => $this->_helper()->__('Easing'),
            'required'  => false,
            'name'      => 'easing',
            'options'   => $easing->getOptionArray(),
        ));

        /** @var Magpleasure_Activecontent_Model_Block_Controls $types  */
        $controls = Mage::getSingleton('activecontent/block_controls');

        $fieldset->addField('controls', 'select', array(
            'label'     => $this->_helper()->__('Controls'),
            'required'  => false,
            'name'      => 'controls',
            'options'   => $controls->getOptionArray(),
        ));

        /** @var Magpleasure_Activecontent_Model_Block_Yesno $types  */
        $yesno = Mage::getSingleton('activecontent/block_yesno');

        $fieldset->addField('autohide', 'select', array(
            'label'     => $this->_helper()->__('Autohide Controls'),
            'required'  => false,
            'name'      => 'autohide',
            'options'   => $yesno->getOptionArray(),
        ));

        $fieldset->addField('pager', 'select', array(
            'label'     => $this->_helper()->__('Display Pager'),
            'required'  => false,
            'name'      => 'pager',
            'options'   => $yesno->getOptionArray(),
        ));

        $fieldset->addField('captions', 'select', array(
            'label'     => $this->_helper()->__('Display Captions'),
            'required'  => false,
            'name'      => 'captions',
            'options'   => $yesno->getOptionArray(),
        ));

        $fieldset = $form->addFieldset('ticker_fieldset', array('legend'=>$this->_helper()->__('Ticker Properties')));

        $fieldset->addField('ticker', 'select', array(
            'label'     => $this->_helper()->__('Ticker'),
            'required'  => false,
            'name'      => 'ticker',
            'options'   => $yesno->getOptionArray(),
            'onchange'  => "if ($('ticker').value == '1' ) { $('slideshow').value = 0; $('play_button').value = 0; }",
            'note'      => $this->_helper()->__("Does not work with Fade type"),
        ));

        $fieldset->addField('ticker_speed', 'text', array(
            'label'     => $this->_helper()->__('Ticker Speed'),
            'required'  => false,
            'name'      => 'ticker_speed',
            'class'     => 'validate-not-negative-number',
            'note'      => $this->_helper()->__('in milliseconds'),
        ));

        $fieldset = $form->addFieldset('slide_show_fieldset', array('legend'=>$this->_helper()->__('Slide Show Properties')));

        $fieldset->addField('slideshow', 'select', array(
            'label'     => $this->_helper()->__('Slide Show'),
            'required'  => false,
            'name'      => 'slideshow',
            'options'   => $yesno->getOptionArray(),
            'onchange'  => "if ($('slideshow').value == '1' ) { $('ticker').value = 0; } else { $('play_button').value = 0; }",
        ));

        $fieldset->addField('play_button', 'select', array(
            'label'     => $this->_helper()->__('Display Play/Pause Button'),
            'required'  => false,
            'name'      => 'play_button',
            'options'   => $yesno->getOptionArray(),
            'onchange'  => "if ($('play_button').value == '1' ) { $('slideshow').value = 1; $('ticker').value = 0; }",
        ));

        $fieldset->addField('slideshow_pause', 'text', array(
            'label'     => $this->_helper()->__('Slide Show Pause'),
            'required'  => false,
            'name'      => 'slideshow_pause',
            'class'     => 'validate-not-negative-number',
            'note'      => $this->_helper()->__('in milliseconds'),
        ));

        $fieldset->addField('duration', 'text', array(
            'label'     => $this->_helper()->__('Slide Show Speed'),
            'required'  => false,
            'name'      => 'duration',
            'class'     => 'validate-not-negative-number',
            'note'      => $this->_helper()->__('in milliseconds'),
        ));

        /** @var Magpleasure_Activecontent_Model_Block_Direction $direction  */
        $direction = Mage::getSingleton('activecontent/block_direction');
        $fieldset->addField('direction', 'select', array(
            'label'     => $this->_helper()->__('Slide Show Direction'),
            'required'  => false,
            'name'      => 'direction',
            'options'   => $direction->getOptionArray(),
        ));


        $fieldset = $form->addFieldset('style_fieldset', array('legend'=>$this->_helper()->__('Look and Feel')));

        /** @var Magpleasure_Activecontent_Block_Adminhtml_System_Config_Form_Element_Preview $previewBox */
        $previewBox = $this->getLayout()->createBlock('activecontent/adminhtml_system_config_form_element_preview');

        /** @var Magpleasure_Activecontent_Model_Block_Styles $styles  */
        $styles = Mage::getSingleton('activecontent/block_styles');
        $fieldset->addField('style', 'select', array(
            'label'     => $this->_helper()->__('Style'),
            'required'  => false,
            'name'      => 'style',
            'options'   => $styles->getOptionArray(),
            'after_element_html' => $previewBox ? $previewBox->toHtml() : false,
        ));

        $values = array();
        if (Mage::registry(Magpleasure_Activecontent_Model_Slider::PATH_IN_REGISTRY) ){

            $values = Mage::registry(Magpleasure_Activecontent_Model_Slider::PATH_IN_REGISTRY)->getData();
        } else {

            $values = Mage::getSingleton('adminhtml/session')->getAcBlockData(true);
        }

        # Define defult values
        foreach ($this->_getTabDefaults() as $key => $value){
            if (!isset($values[$key])){
                $values[$key] = $value;
            }
        }

        $form->setValues($values);

        return parent::_prepareForm();
    }

}
