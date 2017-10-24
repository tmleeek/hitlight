<?php
/**
* @author Evince Team
* @package Evince_Customattribute
*/
class Evince_Customerattr_AttachmentController extends Mage_Core_Controller_Front_Action
{
    public function downloadAction()
    {
        $customerId = $this->getRequest()->getParam('customer');
        if (Mage::getSingleton('customer/session')->isLoggedIn() && $customerId == Mage::getSingleton('customer/session')->getCustomer()->getId()) {
            $fileName = $this->getRequest()->getParam('file');
            $fileName = Mage::helper('core')->urlDecode($fileName);
            $downloadPath = Mage::helper('customattribute')->getAttributeFileUrl($fileName);
            $fileName = Mage::helper('customattribute')->cleanFileName($fileName);
            $downloadPath = $downloadPath . $fileName[1] . DS . $fileName[2] . DS;
            if (file_exists($downloadPath . $fileName[3]))
            {
                header('Content-Disposition: attachment; filename="' . $fileName[3] . '"');               
                if(function_exists('mime_content_type')) 
                {
                    header('Content-Type: ' . mime_content_type($downloadPath . $fileName[3]));                    
                }
                else if(class_exists('finfo'))
                {
                     $finfo = new finfo(FILEINFO_MIME);
                     $mimetype = $finfo->file($downloadPath . $fileName[3]);
                     header('Content-Type: ' . $mimetype);
                }                
                readfile($downloadPath . $fileName[3]); 
            }
        }
        exit;
    }
}