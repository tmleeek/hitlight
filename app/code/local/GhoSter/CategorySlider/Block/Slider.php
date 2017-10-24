<?php

class GhoSter_CategorySlider_Block_Slider extends Mage_Core_Block_Template
{
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getCategorySlider()
    {
        if (!$this->hasData('category_slider')) {
            $this->setData('category_slider', Mage::registry('category_slider'));
        }
        return $this->getData('category_slider');

    }
}