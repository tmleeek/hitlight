<?php

class Hil_Slider_Adminhtml_SliderController extends Mage_Adminhtml_Controller_Action
{
		protected function _isAllowed()
		{
		//return Mage::getSingleton('admin/session')->isAllowed('slider/slider');
			return true;
		}

		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("slider/slider")->_addBreadcrumb(Mage::helper("adminhtml")->__("Slider  Manager"),Mage::helper("adminhtml")->__("Slider Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Slider"));
			    $this->_title($this->__("Manager Slider"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Slider"));
				$this->_title($this->__("Slider"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("slider/slider")->load($id);
				if ($model->getId()) {
					Mage::register("slider_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("slider/slider");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Slider Manager"), Mage::helper("adminhtml")->__("Slider Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Slider Description"), Mage::helper("adminhtml")->__("Slider Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("slider/adminhtml_slider_edit"))->_addLeft($this->getLayout()->createBlock("slider/adminhtml_slider_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("slider")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Slider"));
		$this->_title($this->__("Slider"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("slider/slider")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("slider_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("slider/slider");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Slider Manager"), Mage::helper("adminhtml")->__("Slider Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Slider Description"), Mage::helper("adminhtml")->__("Slider Description"));


		$this->_addContent($this->getLayout()->createBlock("slider/adminhtml_slider_edit"))->_addLeft($this->getLayout()->createBlock("slider/adminhtml_slider_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {

						
				 //save image
		try{

if((bool)$post_data['banner_image']['delete']==1) {

	        $post_data['banner_image']='';

}
else {

	unset($post_data['banner_image']);

	if (isset($_FILES)){

		if ($_FILES['banner_image']['name']) {

			if($this->getRequest()->getParam("id")){
				$model = Mage::getModel("slider/slider")->load($this->getRequest()->getParam("id"));
				if($model->getData('banner_image')){
						$io = new Varien_Io_File();
						$io->rm(Mage::getBaseDir('media').DS.implode(DS,explode('/',$model->getData('banner_image'))));	
				}
			}
						$path = Mage::getBaseDir('media') . DS . 'slider' . DS .'slider'.DS;
						$uploader = new Varien_File_Uploader('banner_image');
						$uploader->setAllowedExtensions(array('jpg','png','gif'));
						$uploader->setAllowRenameFiles(false);
						$uploader->setFilesDispersion(false);
						$destFile = $path.$_FILES['banner_image']['name'];
						$filename = $uploader->getNewFileName($destFile);
						$uploader->save($path, $filename);

						$post_data['banner_image']='slider/slider/'.$filename;
		}
    }
}

        } catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
        }
//save image

                        if(!$this->getRequest()->getParam("id")){
                            $post_data['create_at'] = date('Y-m-d H:i:s');
                        }

						$model = Mage::getModel("slider/slider")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Slider was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setSliderData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setSliderData($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}



		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
						$model = Mage::getModel("slider/slider");
						$model->setId($this->getRequest()->getParam("id"))->delete();
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
						$this->_redirect("*/*/");
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					}
				}
				$this->_redirect("*/*/");
		}

		
		public function massRemoveAction()
		{
			try {
				$ids = $this->getRequest()->getPost('ids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("slider/slider");
					  $model->setId($id)->delete();
				}
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
			}
			catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			}
			$this->_redirect('*/*/');
		}
			
}
