<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 14/07/2016
 * Time: 12:00
 */
class GhoSter_ShopByProject_Helper_Slide extends Mage_Core_Helper_Abstract
{
    /**
     * @param $project_id
     * @param $category_id
     * @return GhoSter_ShopByProject_Model_Resource_Slide_Collection
     */
    public function getSlides($project_id, $category_id)
    {
        $slides = Mage::getModel('ghoster_shopbyproject/slide')->getCollection()
            ->addFieldToSelect("*")
            ->addFieldToFilter('project_id', $project_id)
            ->addFieldToFilter('entity_id', $category_id);

        return $slides;
    }

}
