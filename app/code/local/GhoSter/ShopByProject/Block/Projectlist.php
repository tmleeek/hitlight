<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/5/16
 * Time: 2:15 PM
 */
class GhoSter_ShopByProject_Block_Projectlist extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $projects = Mage::getResourceModel('ghoster_shopbyproject/project_collection');
        $projects->addFieldToFilter('status', 1);
        $projects->setOrder('id', 'asc');
        $this->setProjects($projects);
    }

    /*
     * function process get category list of product by shopbyproject
     * */
    public function getCategoryByProject()
    {
        $data = array();
        $_helper = Mage::helper('catalog/category');
        $_categories = $_helper->getStoreCategories();
        if (count($_categories) > 0){
            foreach($_categories as $_category){
                $_category = Mage::getModel('catalog/category')->load($_category->getId());
                $_subcategories = $_category->getChildrenCategories();
                if ($_category->getEnableShopbyproject() == 1) {
                    //echo $_category->getName().'<hr>';
                    array_push($data, $_category);
                }
            }
        }
        return $data;
    }

    public function getCategoryByProjectChild($cateParentId)
    {
        $data = array();
        $_helper = Mage::helper('catalog/category');
        $_categories = $_helper->getStoreCategories();
        if (count($_categories) > 0){
            $_category = Mage::getModel('catalog/category')->load($cateParentId);
            $_subcategories = $_category->getChildrenCategories();
            if (count($_subcategories) > 0){
                foreach($_subcategories as $_subcategory){
                    $_categoryChild = Mage::getModel('catalog/category')->load($_subcategory->getId());
                    if ($_categoryChild->getEnableShopbyproject() == 1) {
                        array_push($data, $_categoryChild);
                    }
                }
            }
        }
        return $data;
    }
}
