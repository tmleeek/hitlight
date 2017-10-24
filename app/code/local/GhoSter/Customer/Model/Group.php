<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 6/24/2016
 * Time: 10:50 AM
 */
class GhoSter_Customer_Model_Group extends Mage_Core_Model_Abstract
{
    public function toOptionArray()
    {
        $collection = Mage::getResourceModel('customer/group_collection')
            ->addTaxClass();
        foreach ($collection as $id => $group) {


            $categories[$id] = array(
                'value' => $group->getId(),
                'label' => $group->getCode()
            );
        }

        return $categories;
    }
}
