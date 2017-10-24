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
 * Active Content Slide Controller
 */
class Magpleasure_Activecontent_Admin_SlideController extends Magpleasure_Common_Controller_Adminhtml_Action_Grid
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
        $this->_modelName = "activecontent/slide";
        $this->_aclAllowCheckPath = "cms/activecontent/blocks";
        $this->_menuPath = "cms/activecontent/blocks";
        $this->_registryKey = Magpleasure_Activecontent_Model_Slide::PATH_IN_REGISTRY;;
        $this->_sessionDataKey = Magpleasure_Activecontent_Model_Slide::PATH_IN_REGISTRY;
        $this->_massActionField = "slides";
        $this->_idField = 'slide_id';
        $this->_massUpdateStatusValue = "new_status";

        $this->_addMessage("edit", self::KEY_ERROR, $this->_helper()->__("Slide does not exists."));

        $this->_addMessage("save", self::KEY_SUCCESS, $this->_helper()->__("Slide was successfully saved."));
        $this->_addMessage("save", self::KEY_ERROR, $this->_helper()->__("Slide could not be saved for some error."));

        $this->_addMessage("delete", self::KEY_SUCCESS, $this->_helper()->__("Slide was successfully deleted."));
        $this->_addMessage("delete", self::KEY_ERROR, $this->_helper()->__("Slide could not be deleted for some error."));

        $this->_addMessage("duplicate", self::KEY_SUCCESS, $this->_helper()->__("Slide was successfully duplicated."));
        $this->_addMessage("duplicate", self::KEY_ERROR, $this->_helper()->__("Slide could not be duplicated for some error."));

        $this->_addMessage("massStatus", self::KEY_SUCCESS, $this->_helper()->__("%s slides were successfully updated."));
        $this->_addMessage("massStatus", self::KEY_ERROR, $this->_helper()->__("%s slides were not updated for some errors."));

        $this->_addMessage("massDelete", self::KEY_SUCCESS, $this->_helper()->__("%s slides were successfully deleted."));
        $this->_addMessage("massDelete", self::KEY_ERROR, $this->_helper()->__("%s slides were not deleted for some errors."));

        $this->_addMessage("massDuplicate", self::KEY_SUCCESS, $this->_helper()->__("%s slides were successfully duplicated."));
        $this->_addMessage("massDuplicate", self::KEY_ERROR, $this->_helper()->__("%s slides were not duplicated for some errors."));
    }

    protected function _redirect($path, $arguments = array())
    {
        list($route, $controller, $action) = explode("/", $path);

        if (in_array($controller, array("admin_slide", "*"))){

            if ($action == 'index'){

                $arguments['id'] = $this->getRequest()->getParam('id');
                $arguments['tab'] = "slide_section";

                $path = "*/admin_slider/edit";

            } elseif ($action == 'edit') {

                if ($this->getRequest()->getParam('slide_id')){
                    $arguments['slide_id'] = isset($arguments['slide_id']) ? $arguments['slide_id'] : $this->getRequest()->getParam('slide_id');
                }

                $arguments['id'] = $this->getRequest()->getParam('id');
                $path = "*/admin_slide/edit";
            }
        }

        return parent::_redirect($path, $arguments);
    }

    /**
     * Set referer url for redirect in response
     *
     * Is overriden here to set defaultUrl to admin url
     *
     * @param   string $defaultUrl
     * @return  Mage_Adminhtml_Controller_Action
     */
    protected function _redirectReferer($defaultUrl=null)
    {
        if ($this->getRequest()->getActionName() == 'massDuplicate'){

            $arguments = array();
            $arguments['id'] = $this->getRequest()->getParam('id');
            $arguments['tab'] = "slide_section";

            $path = "*/admin_slider/edit";

            $this->_redirect($path, $arguments);

        } elseif ($this->getRequest()->getActionName() == 'massStatus') {

            $arguments = array();
            $arguments['id'] = $this->getRequest()->getParam('id');
            $arguments['tab'] = "slide_section";

            $path = "*/admin_slider/edit";

            $this->_redirect($path, $arguments);


        } else {

            parent::_redirectReferer($defaultUrl);
        }

        return $this;
    }

    protected function _updateField($id, $field, $value)
    {
        if (($field == 'status') && ($value == Magpleasure_Activecontent_Model_Slide::STATUS_ENABLED)){
            return $this->_updateFields($id, array(
                'status' => $value,
                'display_from' => null,
                'display_to' => null,
            ));

        } else {
            return parent::_updateField($id, $field, $value);
        }
    }

    public function saveAction()
    {
        $post = $this->getRequest()->getPost();

        if (isset($post['display_from']) && isset($post['display_from_orig']) && $post['display_from_orig']){
            $post['display_from'] = $this->_helper()->getDate()->convertDateFromSystemToHuman($post['display_from_orig']);
        }

        if (isset($post['display_to']) && isset($post['display_to_orig']) && $post['display_to_orig']){
            $post['display_to'] = $this->_helper()->getDate()->convertDateFromSystemToHuman($post['display_to_orig']);
        }

        $this->getRequest()->setPost($post);

        parent::saveAction();
    }
}