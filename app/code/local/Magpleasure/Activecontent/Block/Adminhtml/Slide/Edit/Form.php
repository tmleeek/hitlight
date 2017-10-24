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
 * @package    Magpleasure_Activecontent
 * @version    1.1.3
 * @copyright  Copyright (c) 2011-2014 MagPleasure Ltd. (http://www.magpleasure.com)
 * @license    http://www.magpleasure.com/LICENSE-CE.txt
 */

/**
 * Activecontent Edit Block Form
 */
class Magpleasure_Activecontent_Block_Adminhtml_Slide_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected $_slider;

    protected function getSlider()
    {
        if (!$this->_slider) {

            $sliderId = $this->getRequest()->getParam('id');

            if ($sliderId) {

                /** @var Magpleasure_Activecontent_Model_Slider $slider */
                $slider = Mage::getModel('activecontent/slider');
                $slider->load($sliderId);
                $this->_slider = $slider;
            }
        }

        return $this->_slider;
    }

    /**
     * Helper
     * @return Magpleasure_Activecontent_Helper_Data
     */
    protected function _helper()
    {
        return Mage::helper('activecontent');
    }

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
                'id' => 'edit_form',
                'action' => $this->getParentBlock()->getSaveUrl(),
                'method' => 'post',
                'enctype' => 'multipart/form-data'
            )
        );

        $fieldset = $form->addFieldset('slide_data', array('legend' => $this->_helper()->__('Content'), 'class' => 'fieldset-wide'));

        $fieldset->addField('title', 'text', array(
            'name' => 'title',
            'label' => $this->_helper()->__('Slide Name'),
            'title' => $this->_helper()->__('Slide Name'),
            'required' => true,
        ));

        $fieldset->addField('position', 'text', array(
            'name' => 'position',
            'label' => $this->_helper()->__('Position'),
            'title' => $this->_helper()->__('Position'),
            'required' => true,
            'class' => 'validate-number',
            'style' => 'width: 274px !important;',
        ));

        try {
            $config = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
            $config->setData($this->_helper()->recursiveReplace(
                    '/activecontent_admin/',
                    '/' . (string)Mage::app()->getConfig()->getNode('admin/routers/adminhtml/args/frontName') . '/',
                    $config->getData()
                )
            );
        } catch (Exception $ex) {
            $config = array();
        }

        $fieldset->addField('slide_content', 'editor', array(
            'name' => 'slide_content',
            'label' => $this->_helper()->__('Content'),
            'title' => $this->_helper()->__('Content'),
            'style' => 'height:26em',
            'required' => true,
            'config' => $config,
        ));

        $fieldset->addField('slider_id', 'hidden', array(
            'name' => 'slider_id',
        ));

        $fieldset = $form->addFieldset('slide_visibility', array('legend' => $this->_helper()->__("Visibility Settings"), 'class' => 'fieldset-wide'));

        /** @var Magpleasure_Activecontent_Model_Slide $slide */
        $slide = Mage::getModel('activecontent/slide');

        $fieldset->addField('status', 'select', array(
            'label' => $this->_helper()->__('Visibility'),
            'title' => $this->_helper()->__('Visibility'),
            'name' => 'status',
            'required' => true,
            'options' => $slide->getStatusArray(),
        ));

        $imagePath = $this->getSkinUrl('images/grid-cal.gif');
        $outputFormat = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);

        $fieldset->addField('display_from', 'date', array(
            'label'  => $this->_helper()->__('Display From'),
            'title'  => $this->_helper()->__('Display From'),
            'name'      => 'display_from',
            'time'      => false,
            'image'      => $imagePath,
            'style'     => 'width: 110px !important; display: inline;',
            'input_format' => Varien_Date::DATETIME_INTERNAL_FORMAT,
            'format'       => $outputFormat,
        ));

        $fieldset->addField('display_to', 'date', array(
            'label'  => $this->_helper()->__('Display To'),
            'title'  => $this->_helper()->__('Display To'),
            'name'      => 'display_to',
            'time'      => false,
            'image'      => $imagePath,
            'style'     => 'width: 110px !important; display: inline;',
            'input_format' => Varien_Date::DATETIME_INTERNAL_FORMAT,
            'format'       => $outputFormat,
        ));

        $fieldset->addField('display_from_orig', 'hidden', array(
            'name'      => 'display_from_orig',
        ));

        $fieldset->addField('display_to_orig', 'hidden', array(
            'name'      => 'display_to_orig',
        ));

        if (Mage::registry(Magpleasure_Activecontent_Model_Slide::PATH_IN_REGISTRY)) {
            $values = Mage::registry(Magpleasure_Activecontent_Model_Slide::PATH_IN_REGISTRY)->getData();
        } else {
            $values = Mage::getSingleton('adminhtml/session')->getData(Magpleasure_Activecontent_Model_Slide::PATH_IN_REGISTRY);
        }

        $values['display_from_orig'] = isset($values['display_from']) ? $values['display_from'] : null;
        $values['display_to_orig'] = isset($values['display_to']) ? $values['display_to'] : null;

        $values['slider_id'] = $this->getRequest()->getParam('id');

        if (!isset($values['status'])){
            $values['status'] = 1;
        }

        if (!isset($values['position'])){

            $slides = $this->getSlider()->getSlideCollection();
            $maxSortOrder = $slides->getMaxPosition();
            $values['position'] = (int) (floor($maxSortOrder/10) + 1) * 10;
        }

        $form->setValues($values);

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}