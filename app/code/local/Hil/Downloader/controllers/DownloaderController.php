<?php

class Hil_Downloader_DownloaderController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function downloaderSaveAction()
    {
        if($this->getRequest()->getPost()){
            try {
                $post_data = $this->getRequest()->getPost();
                $id = Mage::getSingleton('customer/session')->getCustomer()->getId();
                if (isset($id)) {
                    $post_data['create_at'] = date('Y-m-d H:i:s');
                }
                $model = Mage::getModel("downloader/downloader")
                    ->setId($id)
                    ->setData($post_data)
                    ->addData($post_data['create_at']);

                $model ->save();

//                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Success"));
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
//                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                $this->_redirect('*/*/');
            }
        }
        $this->_redirect('*/*/');
    }
}