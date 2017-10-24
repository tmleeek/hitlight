<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/1/16
 * Time: 1:04 PM
 */
class GhoSter_ShopByProject_Adminhtml_AjaxController extends Mage_Adminhtml_Controller_Action
{
    public function getCategoriesTabAction()
    {

        $data = [];

        $categoryIds = explode(',', $this->getRequest()->getParam('ids'));
        $project_id = $this->getRequest()->getParam('project_id');

        foreach ($categoryIds as $categoryId) {
            $category = Mage::getModel('catalog/category')->load($categoryId);
            /* @var $entity Mage_Catalog_Model_Category */
            $data[$category->getId()]['category_id'] = $categoryId;
            $data[$category->getId()]['category_name'] = $category->getName();
            $data[$category->getId()]['project_id'] = $project_id;

        }


        $block_slide = $this->getLayout()->createBlock('ghoster_shopbyproject/adminhtml_project_slide')
            ->setTemplate('ghoster/shopbyproject/slides.phtml')
            ->setCategories($data);

        $block_description = $this->getLayout()->createBlock('core/template')
            ->setTemplate('ghoster/shopbyproject/description.phtml')
            ->setCategories($data);

        $block_shopall = $this->getLayout()->createBlock('core/template')
            ->setTemplate('ghoster/shopbyproject/shopallproducts.phtml')
            ->setCategories($data);

        $block_common = $this->getLayout()->createBlock('core/template')
            ->setTemplate('ghoster/shopbyproject/common_product.phtml')
            ->setCategories($data);

        $content['common_products'] = $block_common->toHtml();
        $content['slides'] = $block_slide->toHtml();
        $content['slideScript'] = $block_slide->getSlideJs();
        $content['products'] = $block_shopall->toHtml();
        $content['description'] = $block_description->toHtml();
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($content));
    }
}
