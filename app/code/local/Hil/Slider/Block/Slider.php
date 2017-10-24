<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/15/16
 * Time: 2:53 PM
 */
class Hil_Slider_Block_Slider extends Mage_Core_Block_Template
{
    public function getSlider() {
        $slider = Mage::getModel('slider/slider')->getCollection()
            ->addFieldToFilter('status', '1')
            ->setOrder('id', 'DESC');

        return $slider;
    }
}
