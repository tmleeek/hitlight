<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/15/16
 * Time: 2:25 PM
 */
class Cyberfision_Custom_Model_System_Config_Source_Bannertype
{
    CONST BANNER_COLUMN_TYPE_1 = 1;
    CONST BANNER_COLUMN_TYPE_2 = 2;

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $lists = array();

        $lists [] = array('value' => self::BANNER_COLUMN_TYPE_1, 'label' => Mage::helper('cyberfision_custom')->__('--- 1 Column ---'));
        $lists [] = array('value' => self::BANNER_COLUMN_TYPE_2, 'label' => Mage::helper('cyberfision_custom')->__('--- 2 Columns ---'));

        return $lists;
    }
}
