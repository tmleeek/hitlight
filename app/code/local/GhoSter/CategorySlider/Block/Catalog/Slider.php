<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/21/16
 * Time: 11:48 AM
 */
class GhoSter_CategorySlider_Block_Catalog_Slider extends Mage_Core_Block_Template
{
    /**
     * Set Template
     *
     * @return Mage_Core_Block_Abstract
     */
    protected function _beforeToHtml()
    {
        if (!$this->getTemplate()) {
            $this->setTemplate('ghoster/categoryslider/catalog_slider.phtml');
        }
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve current category model object
     *
     * @return Mage_Catalog_Model_Category
     */
    public function getCurrentCategory()
    {
        if (!$this->hasData('current_category')) {
            $this->setData('current_category', Mage::registry('current_category'));
        }
        return $this->getData('current_category');
    }

}
