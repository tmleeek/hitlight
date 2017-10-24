<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/1/16
 * Time: 3:06 PM
 */
class GhoSter_ShopByProject_Model_Categories extends Mage_Core_Model_Abstract
{
    public function toOptionArray()
    {
        $categories = [];
        $allCategoriesCollection = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('name')
            ->addFieldToFilter('level', array('gt' => '0'));

        $allCategoriesArray = $allCategoriesCollection->load()->toArray();

        $categoriesArray = $allCategoriesCollection
            ->addAttributeToSelect('level')
            ->addAttributeToSort('path', 'asc')
            ->addFieldToFilter('is_active', array('eq' => '1'))
            ->addFieldToFilter('level', array('gt' => '1'))
            ->load()
            ->toArray();
        foreach ($categoriesArray as $categoryId => $category) {
            if (!isset($category['name'])) {
                continue;
            }

            $categoryIds = explode('/', $category['path']);

            $nameParts = array();

            foreach ($categoryIds as $catId) {
                if ($catId == 1) {
                    continue;
                }
                $nameParts[] = $allCategoriesArray[$catId]['name'];
            }

            $categories[$categoryId] = array(
                'value' => $categoryId,
                'label' => implode('/', $nameParts)
            );
        }

        return $categories;
    }
}
