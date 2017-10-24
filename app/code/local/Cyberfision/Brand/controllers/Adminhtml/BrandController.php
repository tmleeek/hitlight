<?php
class Cyberfision_Brand_Adminhtml_BrandController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $brandBlock = $this->getLayout()
            ->createBlock('cyberfision_brand_adminhtml/brand');
        $this->loadLayout()
            ->_addContent($brandBlock)
            ->renderLayout();
    }

    public function editAction()
    {
        $brand = Mage::getModel('cyberfision_brand/brand');
        if ($brandId = $this->getRequest()->getParam('id', false)) {

            $brand->load($brandId);

            if (!$brand->getId()){
                $this->_getSession()->addError($this->__('This item no longer exists.'));
                return $this->_redirect('cyberfision_brand_admin/brand/index');
            }
        }

        if ($postData = $this->getRequest()->getPost('brandData')) {
            
            $images = $this->getRequest()->getPost('image');

            try {
                $brand->addData($postData);
            	try {	
                    if (count($images)) {
                        $imageName = Mage::helper('core')->jsonEncode($images);
                    } else {
                        $imageName = "";
                    }   
                    
                    $brand->setImage($imageName);                		
            	} catch (Exception $e) {
            		var_dump($e); exit;
            	}

                if (isset($_FILES['brandData']['name']['banner']) && $_FILES['brandData']['name']['banner'] != '') {
                    try {
                        $path = Mage::getBaseDir('media') . DS;
                        $imageName = $_FILES['brandData']['name']['banner'];
                        move_uploaded_file($_FILES['brandData']['tmp_name']['banner'], $path . $_FILES['brandData']['name']['banner']);
                        $brand->setBanner($imageName);
                    } catch (Exception $e) {
                        var_dump($e); exit;
                    }
                } else {
                    if ($brand->getBanner() =="") {
                        $brand->setBanner("");
                    } else {
                        $old = $brand->getData('banner')['value'];
                        $brand->setBanner($old);
                    }
                }

                //echo "<pre>"; var_dump($brand); die;
                      
                $brand->save();
                $this->_getSession()->addSuccess(
                $this->__('The item has been saved.')
            );

            return $this->_redirect(
                'cyberfision_brand_admin/brand/edit',
                    array('id' => $brand->getId())
                );
                
            } catch (Exception $e) {
                Mage::logException($e);
                $this->_getSession()->addError($e->getMessage());
            }

        }

        Mage::register('current_brand', $brand);

        $brandEditBlock = $this->getLayout()->createBlock(
            'cyberfision_brand_adminhtml/brand_edit'
        );
        $this->loadLayout();
        
        $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);


        $this->_addContent($brandEditBlock)
            ->renderLayout();
    }

    public function deleteAction()
    {
        $brand = Mage::getModel('cyberfision_brand/brand');

        if ($brandId = $this->getRequest()->getParam('id', false)) {
            $brand->load($brandId);
        }

        if (!$brand->getId()){
            $this->_getSession()->addError($this->__('This item no longer exists.'));
            return $this->_redirect('cyberfision_brand_admin/brand/index');
        }

        try {
        $brand->delete();

        $this->_getSession()->addSuccess(
        $this->__('The item has been deleted.')
        );
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
        }

        return $this->_redirect(
            'cyberfision_brand_admin/brand/index'
        );
    }

    protected function _isAllowed()
    {
        $actionName = $this->getRequest()->getActionName();
        switch ($actionName) {
            case 'index':
            case 'edit':
            case 'delete':
            default:
                $adminSession = Mage::getSingleton('admin/session');
                $isAllowed = $adminSession
                    ->isAllowed('cyberfision_brand/brand');
                break;
        }

        return $isAllowed;
    }

}