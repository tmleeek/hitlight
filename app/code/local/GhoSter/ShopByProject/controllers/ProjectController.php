<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/5/16
 * Time: 2:32 PM
 */
class GhoSter_ShopByProject_ProjectController extends Mage_Core_Controller_Front_Action
{
    /**
     * Init Shop By Project
     *
     * @param string $idFieldName
     * @return $this
     */
    protected function _initProject($idFieldName = 'id')
    {
        $projectId = (int)$this->getRequest()->getParam($idFieldName);
        $project = Mage::getModel('ghoster_shopbyproject/project');

        if ($projectId) {
            $project->load($projectId);
            $project->setData('categories', Mage::helper('ghoster_shopbyproject')->getSelectedCategories($projectId));
        }

        Mage::register('current_project', $project);

        return $this;
    }

    /**
     * View Action
     */
    public function viewAction()
    {
        $this->_initProject();

        /* @var $project GhoSter_ShopByProject_Model_Project */
        $project = Mage::registry('current_project');

        $this->_title($this->__('Projects'))->_title($project->getTitle());
        $this->loadLayout();

        $this->renderLayout();
    }

    public function indexAction()
    {
        $this->loadLayout();

        $this->renderLayout();
    }

    public function multipleProdAddAction()
    {
        $product_ids = explode(',', $this->getRequest()->getParam('product_ids'));
        $cart = Mage::getSingleton('checkout/cart');

        /* @var $product Mage_Catalog_Model_Product */
        foreach ($product_ids as $product_id) {
            if ($product_id == '') {
                continue;
            }
            $product = Mage::getModel('catalog/product')->load($product_id);

            if ($product->getTypeId() == "simple" && $product->isSaleable()) {
                try {
                    $cart->addProduct($product, array('qty' => '1'));
                } catch (Exception $e) {
                    continue;
                }
            }
        }


        $cart->save();

        if ($this->getRequest()->isXmlHttpRequest()) {
            exit('1');
        }

        $this->_redirect('checkout');
    }
}
