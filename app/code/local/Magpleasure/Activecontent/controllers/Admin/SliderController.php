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
 * Active Content Slider Controller
 */
class Magpleasure_Activecontent_Admin_SliderController extends Magpleasure_Common_Controller_Adminhtml_Action_Grid
{
    /**
     * Helper
     *
     * @return Magpleasure_Activecontent_Helper_Data
     */
    protected function _helper()
    {
        return Mage::helper('activecontent');
    }

    protected function _construct()
    {
        parent::_construct();

        # Init abstract grid action
        $this->_modelName = "activecontent/slider";
        $this->_aclAllowCheckPath = "cms/activecontent/blocks";
        $this->_menuPath = "cms/activecontent/blocks";
        $this->_registryKey = Magpleasure_Activecontent_Model_Slider::PATH_IN_REGISTRY;;
        $this->_sessionDataKey = Magpleasure_Activecontent_Model_Slider::PATH_IN_REGISTRY;
        $this->_massActionField = "sliders";

        $this->_addMessage("edit", self::KEY_ERROR, $this->_helper()->__("Slider does not exists."));

        $this->_addMessage("save", self::KEY_SUCCESS, $this->_helper()->__("Slider was successfully saved."));
        $this->_addMessage("save", self::KEY_ERROR, $this->_helper()->__("Slider could not be saved for some error."));

        $this->_addMessage("delete", self::KEY_SUCCESS, $this->_helper()->__("Slider was successfully deleted."));
        $this->_addMessage("delete", self::KEY_ERROR, $this->_helper()->__("Slider could not be deleted for some error."));

        $this->_addMessage("duplicate", self::KEY_SUCCESS, $this->_helper()->__("Slider was successfully duplicated."));
        $this->_addMessage("duplicate", self::KEY_ERROR, $this->_helper()->__("Slider could not be duplicated for some error."));

        $this->_addMessage("massStatus", self::KEY_SUCCESS, $this->_helper()->__("%s sliders were successfully updated."));
        $this->_addMessage("massStatus", self::KEY_ERROR, $this->_helper()->__("%s sliders were not updated for some errors."));

        $this->_addMessage("massDelete", self::KEY_SUCCESS, $this->_helper()->__("%s sliders were successfully deleted."));
        $this->_addMessage("massDelete", self::KEY_ERROR, $this->_helper()->__("%s sliders were not deleted for some errors."));

        $this->_addMessage("massDuplicate", self::KEY_SUCCESS, $this->_helper()->__("%s sliders were successfully duplicated."));
        $this->_addMessage("massDuplicate", self::KEY_ERROR, $this->_helper()->__("%s sliders were not duplicated for some errors."));
    }

    public function newAction()
    {
        $this->_getSession()->addNotice($this->_helper()->__("Please save the Slider to add Slides."));
        parent::newAction();
    }

    public function saveAction()
    {
        if (!$this->getRequest()->has('use_size')){
            $this->getRequest()->setPost('use_size', 0);
        } else {
            $this->getRequest()->setPost('use_size', 1);
        }

        parent::saveAction();
    }
}