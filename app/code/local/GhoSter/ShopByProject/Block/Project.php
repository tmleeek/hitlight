<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/5/16
 * Time: 2:08 PM
 */
class GhoSter_ShopByProject_Block_Project extends Mage_Core_Block_Template
{
    public function getCurrentProject(){
        return Mage::registry('current_project');
    }
}
