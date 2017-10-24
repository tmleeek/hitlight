<?php

class GhoSter_ShopByProject_Adminhtml_GeneratorController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu("shop_by_project/generator")->_addBreadcrumb(Mage::helper("adminhtml")->__("Generator  Manager"), Mage::helper("adminhtml")->__("Generator Manager"));
        return $this;
    }

    public function indexAction()
    {
        $this->_title($this->__("ShopByProject"));
        $this->_title($this->__("Manager Instruction Blocks"));

        $this->_initAction();
        $this->renderLayout();
    }

    public function editAction()
    {
        $this->loadLayout();

        $this->_title($this->__("ShopByProject"));
        $this->_title($this->__("Instruction Blocks"));
        $this->_title($this->__("Edit Instruction Block"));

        $id = $this->getRequest()->getParam("id");
        $model = Mage::getModel("ghoster_shopbyproject/instruction")->load($id);
        if ($model->getId()) {
            Mage::register("generator_data", $model);
        }


        $this->_setActiveMenu("shop_by_project/generator");
        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Instruction Blocks Manager"), Mage::helper("adminhtml")->__("Instruction Blocks Manager"));
        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Instruction Blocks Description"), Mage::helper("adminhtml")->__("Instruction Blocks Description"));


        $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
        $this->_addContent($this->getLayout()->createBlock("ghoster_shopbyproject/adminhtml_generator_edit"))->_addLeft($this->getLayout()->createBlock("ghoster_shopbyproject/adminhtml_generator_edit_tabs"));
        $this->renderLayout();
    }

    /**
     * Create new Instruction action
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    public function saveAction()
    {

        $post_data = $this->getRequest()->getPost();

        $model = Mage::getModel("ghoster_shopbyproject/instruction");


        /* @var $instruction GhoSter_ShopByProject_Model_Instruction */
        $instruction = Mage::registry('generator_data');

        if ($post_data) {

            $dataCms = array(
                'title'=> $post_data['title'],
                'identifier'=> 'instruction_'. $post_data['identifier'],
                'stores'=> array(0),
                'is_active'=> 1,
                'content'=>'',
                'use_instruction'=>1
            );

            $id = $this->getRequest()->getParam('id');
            $cmsBlock = Mage::getModel('cms/block');

            if($id){
                $model->load($id);
                $post_data['entity_id'] = $model->getEntityId();
                $cmsBlock->load($model->getEntityId());


            }else{
                $cmsBlock->setId(null)
                    ->setData($dataCms)
                    ->save();
                $post_data['entity_id'] = $cmsBlock->getId();

            }

            $post_data['data'] = Mage::helper('core')->jsonEncode($post_data['instruction_step']);

            try {
                    $model->addData($post_data)
                        ->setId($id)
                        ->setData($post_data['data'])
                        ->save();


                if($id) {
                    $templateHtml = $this->getLayout()->createBlock('core/template')->setInstructionData($model->getEntityId())->setStepData(Mage::helper('core')->jsonDecode($post_data['data']))->setTemplate('ghoster/shopbyproject/template/instruction.phtml');
                } else {
                    $templateHtml = $this->getLayout()->createBlock('core/template')->setInstructionData($cmsBlock->getId())->setStepData(Mage::helper('core')->jsonDecode($post_data['data']))->setTemplate('ghoster/shopbyproject/template/instruction.phtml');
                }


                $cmsBlock->setContent($templateHtml->toHtml())
                    ->save();


                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Instruction Block was successfully saved"));
                Mage::getSingleton("adminhtml/session")->setGeneratorData(false);

                if ($this->getRequest()->getParam("back")) {
                    $this->_redirect("*/*/edit", array("id" => $model->getId()));
                    return;
                }
                $this->_redirect("*/*/");
                return;
            } catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                Mage::getSingleton("adminhtml/session")->setGeneratorData($this->getRequest()->getPost());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
                return;
            }

        }
        $this->_redirect("*/*/");
    }


    public function deleteAction()
    {
        if ($this->getRequest()->getParam("id") > 0) {
            try {
                $model = Mage::getModel("ghoster_shopbyproject/instruction");
                $instruction = $model->load($this->getRequest()->getParam("id"));

                $block = Mage::getModel('ghoster_shopbyproject/instruction')->load($instruction->getEntityId());
                $block->delete();
                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
                $this->_redirect("*/*/");
            } catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
            }
        }
        $this->_redirect("*/*/");
    }
}
