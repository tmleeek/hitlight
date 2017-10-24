<?php

class GhoSter_CategorySlider_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Get Category Slider Config
     *
     * @return array|$config
     */
    public function getStoreConfig()
    {
        $config = [];

        $config['transition'] = (Mage::getStoreConfig('category_slider/general/transition', Mage::app()->getStore()));
        $config['pager'] = (Mage::getStoreConfig('category_slider/general/pager', Mage::app()->getStore()));
        $config['controls'] = (Mage::getStoreConfig('category_slider/general/controls', Mage::app()->getStore()));
        $config['speed'] = (Mage::getStoreConfig('category_slider/general/speed', Mage::app()->getStore()));
        $config['pause_on_hover'] = (Mage::getStoreConfig('category_slider/general/pauseonhover', Mage::app()->getStore()));
        $config['easing'] = (Mage::getStoreConfig('category_slider/general/easing', Mage::app()->getStore()));
        $config['enable'] = Mage::getStoreConfig('category_slider/general/active');
        $config['categories'] = explode(',', Mage::getStoreConfig('category_slider/general/categories', Mage::app()->getStore()));

        return $config;

    }


    /**
     * Get Child Level-1 Category After Category
     *
     * @param $category_id
     * @return array
     */
    public function getChildCategory($category_id)
    {
        $data = [];

        $category = Mage::getModel('catalog/category')->load($category_id);

        $_categories = $category->getChildrenCategories();

        foreach ($_categories as $child_category) {
            /* @var $child_category Mage_Catalog_Model_Category */
            $data[$child_category->getId()]['title'] = $child_category->getName();
            $data[$child_category->getId()]['url'] = $child_category->getUrl();
        }

        return $data;
    }

    /**
     * Get Category Data
     *
     * @param $category_id
     * @return array
     */
    public function getCategoryData($category_id)
    {
        $data = [];
        $category = Mage::getModel('catalog/category')->load($category_id);

        /* @var $category  Mage_Catalog_Model_Category */
        $data['title'] = $category->getName();
        $data['url'] = $category->getUrl();
        $data['image'] = $category->getImageUrl();

        return $data;
    }


    public function getSortedCollectionCategory($_categoryIds){

        $collection = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('entity_id', array('in' => $_categoryIds))
            ->setOrder('home_order');

        return $collection;

    }


    public function getCategorySlider($_category)
    {
        return Mage::helper('core')->jsonDecode($_category->getData('slider_params'));
    }

    public function getClassRenderer($index)
    {
        $classes = [];
        $classes[1] = 'first odd';
        $classes[2] = 'second even';
        $classes[3] = 'last-table odd last-home-category';
        $classes[4] = 'fourth first-table even';
        $classes[5] = 'fifth odd';
        $classes[6] = 'six last-table even';
        $classes[7] = 'last odd last-home-category';

        foreach ($classes as $key => $class) {
            if ($index == $key) {
                return $class;
            }
        }
    }

}