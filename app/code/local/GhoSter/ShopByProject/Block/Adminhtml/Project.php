<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/1/16
 * Time: 2:21 PM
 */

class GhoSter_ShopByProject_Block_Adminhtml_Project extends Mage_Adminhtml_Block_Widget_Grid_Container {
    /**
     * Modify header & button labels
     *
     */
    public function __construct()
    {
        $this->_controller = "adminhtml_project";
        $this->_blockGroup = "ghoster_shopbyproject";
        $this->_headerText = Mage::helper("ghoster_shopbyproject")->__("Manage Applications");
        $this->_addButtonLabel = Mage::helper("ghoster_shopbyproject")->__("Add New Applications");
        parent::__construct();
    }
}
