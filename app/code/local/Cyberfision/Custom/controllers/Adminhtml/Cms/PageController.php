<?php
require_once ('Mage/Adminhtml/controllers/Cms/PageController.php');

class Cyberfision_Custom_Adminhtml_Cms_PageController extends Mage_Adminhtml_Cms_PageController {
    public function saveAction()
    {
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {

            if(isset($_FILES['cyberfision_banner']['name']) && $_FILES['cyberfision_banner']['name'] != '') {
                try {
                    $uploader = new Varien_File_Uploader('cyberfision_banner');
                    // Any extention would work
                    //$uploader->setAllowedExtensions(array('csv','jpeg','gif','png'));
                    $uploader->setAllowRenameFiles(false);
                    $uploader->setFilesDispersion(false);
                    $image_name = time() . '-' . $_FILES['cyberfision_banner']['name'];

                    $path = Mage::getBaseDir('media') . DS . 'banner/' ;
                    $uploader->save($path, $image_name );
                } catch (Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                }

                //this way the name is saved in DB
                $data['cyberfision_banner'] = 'banner/' . $image_name;
            }

            $data = $this->_filterPostData($data);
            //init model and set data
            $model = Mage::getModel('cms/page');

            if ($id = $this->getRequest()->getParam('page_id')) {
                $model->load($id);
            }

            $model->setData($data);

            Mage::dispatchEvent('cms_page_prepare_save', array('page' => $model, 'request' => $this->getRequest()));

            //validating
            if (!$this->_validatePostData($data)) {
                $this->_redirect('*/*/edit', array('page_id' => $model->getId(), '_current' => true));
                return;
            }

            // try to save it
            try {
                // save the data
                $model->save();

                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('cms')->__('The page has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('page_id' => $model->getId(), '_current'=>true));
                    return;
                }
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
            catch (Exception $e) {
                $this->_getSession()->addException($e,
                    Mage::helper('cms')->__('An error occurred while saving the page.'));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('page_id' => $this->getRequest()->getParam('page_id')));
            return;
        }
        $this->_redirect('*/*/');
    }
}