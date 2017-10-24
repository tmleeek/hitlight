<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/1/16
 * Time: 1:04 PM
 */
class GhoSter_ShopByProject_Adminhtml_ProjectController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Init Shop By Project
     *
     * @param string $idFieldName
     * @return $this
     */
    protected function _initProject($idFieldName = 'id')
    {
        $this->_title($this->__('Projects'))->_title($this->__('Manage Projects'));

        $projectId = (int)$this->getRequest()->getParam($idFieldName);
        $project = Mage::getModel('ghoster_shopbyproject/project');
        $project->setData('categories', Mage::getModel('ghoster_shopbyproject/categories')->toOptionArray());


        if ($projectId) {
            $project->load($projectId);
            $project->setData('categories', Mage::helper('ghoster_shopbyproject')->getSelectedCategories($projectId));
        }

        Mage::register('current_project', $project);

        return $this;
    }


    public function indexAction()
    {
        $this->_title($this->__('Projects'))->_title($this->__('Manage Projects'));

        if ($this->getRequest()->getQuery('ajax')) {
            $this->_forward('grid');
            return;
        }
        $this->loadLayout();

        /**
         * Set active menu item
         */
        $this->_setActiveMenu('shop_by_project/manage');

        /**
         * Append measurement type block to content
         */
        $this->_addContent(
            $this->getLayout()->createBlock('ghoster_shopbyproject/adminhtml_project', 'shop_by_project')
        );

        /**
         * Add breadcrumb item
         */
        $this->_addBreadcrumb(Mage::helper('ghoster_shopbyproject')->__('Projects'), Mage::helper('ghoster_shopbyproject')->__('Projects'));
        $this->_addBreadcrumb(Mage::helper('ghoster_shopbyproject')->__('Manage Projects'), Mage::helper('ghoster_shopbyproject')->__('Manage Projects'));

        $this->renderLayout();
    }


    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Project edit action
     */
    public function editAction()
    {
        $this->_initProject();
        $this->loadLayout();

        /* @var $project GhoSter_ShopByProject_Model_Project */
        $project = Mage::registry('current_project');


        $this->_title($project->getId() ? $project->getTitle() : $this->__('New Project'));

        /**
         * Set active menu item
         */
        $this->_setActiveMenu('shop_by_project/manage');

        $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

        $this->_addContent($this->getLayout()->createBlock("ghoster_shopbyproject/adminhtml_project_edit"))->_addLeft($this->getLayout()->createBlock("ghoster_shopbyproject/adminhtml_project_edit_tabs"));

        $this->renderLayout();
    }

    /**
     * Create new Project action
     */
    public function newAction()
    {
        $this->_forward('edit');
    }


    /**
     * Create or save Project.
     */

    public function saveAction()
    {
        $data = $this->getRequest()->getPost();
        if ($data) {
            $redirectBack = $this->getRequest()->getParam('back', false);
            $this->_initProject('id');

            /* @var $project GhoSter_ShopByProject_Model_Project */
            $project = Mage::registry('current_project');


            $model = Mage::getModel('ghoster_shopbyproject/project');

            try {

                if (is_null($data['created_at'])) {
                    $model->setData('created_at', Varien_Date::now());
                }


                $model->addData($data)
                    ->setId($project->getId())
                    ->setData('project_image', parse_url($data['project_image'])['path'])
                    ->save();


                $categories = Mage::getModel('ghoster_shopbyproject/category')->getCollection();
                $categories->addFieldToFilter('entity_id', $model->getId());


                foreach ($categories as $category) {
                    $category->setId($category->getId())->delete();
                    $category_ids[] = $category->getId();
                }

                // Common Products
                $common_products = Mage::getModel('ghoster_shopbyproject/commonproduct')->getCollection();
                $common_products->addFieldToFilter('project_id', $project->getId());

                foreach ($common_products as $common_product) {
                    $common_product->setId($common_product->getId())->delete();
                }

                // Slides
                $slides = Mage::getModel('ghoster_shopbyproject/slide')->getCollection();
                $slides->addFieldToFilter('project_id', $model->getId());

                foreach ($slides as $slide) {
                    $slide->setId($slide->getId())->delete();
                }

                if ($data['categories']) {
                        //$this->saveProject($data);
                        foreach ($data['categories'] as $category_id) {
                            $data_category = [];
                            $data_category['entity_id'] = $model->getId();
                            $data_category['category_id'] = $category_id;
                            $data_category['how_to'] = $data['how_to'][$category_id];

                            $data_category['summary'] = $data['summary'][$category_id];

                            $data_category['instruction_block_id'] = $data['instruction_block_id'][$category_id];
                            $category = Mage::getModel('ghoster_shopbyproject/category');
                            $category->addData($data_category);
                            $category->save();

                            // Common Products
                            if ($data['common_products']) {
                                foreach ($data['common_products'][$category_id] as $common_product_id) {
                                    $common_product = Mage::getModel('ghoster_shopbyproject/commonproduct');
                                    $data_common_product = [];
                                    $data_common_product['project_id'] = $model->getId();
                                    $data_common_product['entity_id'] = $category->getId();
                                    $data_common_product['product_id'] = $common_product_id;
                                    $common_product->addData($data_common_product);
                                    $common_product->save();

                                }
                            }

                            // Slides
                            if ($data['slider_images']) {
                                foreach ($data['slider_images'][$category_id] as $key => $image) {
                                    $slide = Mage::getModel('ghoster_shopbyproject/slide');
                                    $data_slide = [];
                                    $data_slide['project_id'] = $model->getId();
                                    $data_slide['entity_id'] = $category->getId();
                                    $data_slide['slide_image'] = parse_url($image)['path'];
                                    $data_slide['slide_url'] = $data['slider_urls'][$category_id][$key];
                                    $slide->addData($data_slide);
                                    $slide->save();

                                }
                            }

                            // Shop All Products
                            if ($data['products']) {
                                foreach ($data['products'][$category_id] as $product_skus) {
                                    $shopallproducts = Mage::getModel('ghoster_shopbyproject/shopallproducts');
                                    $data_shopallproducts = [];
                                    $data_shopallproducts['project_id'] = $model->getId();
                                    $data_shopallproducts['entity_id'] = $category->getId();
                                    $data_shopallproducts['product_skus'] = $product_skus;
                                    $shopallproducts->addData($data_shopallproducts);
                                    $shopallproducts->save();
                                }
                            }
                        }

                }

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper("ghoster_shopbyproject")->__("Project was successfully saved"));
                Mage::getSingleton('adminhtml/session')->setProjectData(false);

                if ($redirectBack) {
                    $this->_redirect('*/*/edit', array(
                        'id' => $model->getId(),
                        '_current' => true
                    ));
                    return;

                }

                $this->_redirect("*/*/");
                return;

            } catch (Exception $e) {

                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());

                Mage::getSingleton('adminhtml/session')->setProjectData($data);
                $this->_redirect("*/*/edit", array("id" => $model->getId()));

                return;

            }

        } else {

            $this->_forward('new');

        }
    }


    /**
     * Delete Measurement Type action
     */

    public function deleteAction()
    {
        $this->_initProject();
        /* @var $project GhoSter_ShopByProject_Model_Project */
        $project = Mage::registry('current_project');
        if ($project->getId()) {
            try {
                $project->setId($project->getId());
                $project->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('ghoster_shopbyproject')->__('Project has been deleted.'));

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*');
    }


    /**
     * Mass Delete Project action
     */
    public function massDeleteAction()
    {
        try {
            $ids = $this->getRequest()->getPost('ids', array());
            foreach ($ids as $id) {
                $project = Mage::getModel("ghoster_shopbyproject/project");
                $project->setId($id)->delete();
            }

            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper("ghoster_shopbyproject")->__("Total of %d record(s) were deleted.", count($ids)));
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*/');
    }

    /**
     * Export grid to CSV format
     */
    public function exportCsvAction()
    {
        $fileName = 'shop_by_project.csv';
        $grid = $this->getLayout()->createBlock('ghoster_shopbyproject/adminhtml_project_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     *  Export  grid to Excel XML format
     */
    public function exportExcelAction()
    {
        $fileName = 'shop_by_project.xml';
        $grid = $this->getLayout()->createBlock('ghoster_shopbyproject/adminhtml_project_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('admin_shop_by_project/project');
    }
}
