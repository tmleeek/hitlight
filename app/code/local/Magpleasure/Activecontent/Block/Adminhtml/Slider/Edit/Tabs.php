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
 * Activecontent Edit Block Form Tabs
 */
class Magpleasure_Activecontent_Block_Adminhtml_Slider_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('slider_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle($this->__('Slider Information'));
    }

    /**
     * Block
     *
     * @return Magpleasure_Activecontent_Model_Slider
     */
    protected function _getSlider()
    {
        return Mage::registry(Magpleasure_Activecontent_Model_Slider::PATH_IN_REGISTRY);
    }

    protected function _isActive($tabName)
    {
        return $this->getRequest()->getParam('tab') == $tabName;
    }

    protected function _getButtonsHtml()
    {
        $html = "";

        /** @var Mage_Adminhtml_Block_Widget_Button $button */
        $button = $this->getLayout()->createBlock('adminhtml/widget_button');
        if ($button){

            $addUrl = $this->getUrl('*/admin_slide/new', array(
                'id' => $this->getRequest()->getParam('id'),
            ));

            $button->addData(array(
                'label' => $this->__("Add Slide"),
                'title' => $this->__("Add Slide"),
                'class' => "add",
                'onclick' => "setLocation('{$addUrl}'); return false;"
            ));

            $html .= $button->toHtml();
        }

        return $html;
    }

    protected function _wrapGridIntoContainer($gridHtml)
    {
        $slidesLabel = $this->__("Manage Slides");
        $buttonsHtml = $this->_getButtonsHtml();
        $leftHtml = "<div class=\"entry-edit\">
        <div class=\"entry-edit-head\"><h4 class=\"icon-head head-edit-form fieldset-legend\">{$slidesLabel}</h4>
            <div class=\"form-buttons\">{$buttonsHtml}</div>
        </div>
    ";
        $rightHtml = "<div id=\"slides\" class=\"fieldset\">{$gridHtml}</div>";
        return $leftHtml.$rightHtml;
    }

    protected function _beforeToHtml()
    {
        $this->addTab('general_section', array(
            'label'     => $this->__('General'),
            'title'     => $this->__('General'),
            'content'   => $this->getLayout()
                            ->createBlock('activecontent/adminhtml_slider_edit_tabs_general')->toHtml(),
            'active'    => $this->_isActive('general_section'),
        ));

        $this->addTab('properties_section', array(
            'label'     => $this->__('Properties and Style'),
            'title'     => $this->__('Properties and Style'),
            'content'   => $this->getLayout()
                            ->createBlock('activecontent/adminhtml_slider_edit_tabs_properties')->toHtml(),
            'active'    => $this->_isActive('properties_section'),
        ));

        if ($this->_getSlider() && $this->_getSlider()->getId()){
            $this->addTab('slide_section', array(
                'label'     => $this->__('Slides'),
                'title'     => $this->__('Slides'),
                'content'   => $this->_wrapGridIntoContainer(
                        $this->getLayout()->createBlock('activecontent/adminhtml_slider_edit_tabs_content')->toHtml()
                    ),
                'active'    => $this->_isActive('slide_section'),
            ));
        }

        return parent::_beforeToHtml();
    }
}