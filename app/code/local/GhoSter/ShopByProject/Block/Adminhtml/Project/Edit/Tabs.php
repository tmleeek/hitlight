<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/1/16
 * Time: 2:59 PM
 */

class GhoSter_ShopByProject_Block_Adminhtml_Project_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId("project_tabs");
        $this->setDestElementId("edit_form");
        $this->setTitle(Mage::helper("ghoster_shopbyproject")->__("Project Information"));
    }

    protected function _beforeToHtml()
    {
        $this->addTab("project_info", array(
            "label" => Mage::helper("ghoster_shopbyproject")->__("Project Information"),
            "title" => Mage::helper("ghoster_shopbyproject")->__("Project Information"),
            "content" => $this->getLayout()->createBlock('ghoster_shopbyproject/adminhtml_project_edit_tabs_project')->toHtml(),
        ));


        $this->addTab("common_product", array(
            "label" => Mage::helper("ghoster_shopbyproject")->__("Common Products"),
            "title" => Mage::helper("ghoster_shopbyproject")->__("Common Products"),
            "content" => $this->getLayout()->createBlock('ghoster_shopbyproject/adminhtml_project_edit_tabs_commonproduct')->toHtml(),
        ));

        $this->addTab("slide", array(
            "label" => Mage::helper("ghoster_shopbyproject")->__("Slider"),
            "title" => Mage::helper("ghoster_shopbyproject")->__("Slider"),
            "content" => $this->getLayout()->createBlock('ghoster_shopbyproject/adminhtml_project_edit_tabs_slide')->toHtml(),
        ));

        $this->addTab("description", array(
            "label" => Mage::helper("ghoster_shopbyproject")->__("Description"),
            "title" => Mage::helper("ghoster_shopbyproject")->__("Description"),
            "content" => $this->getLayout()->createBlock('ghoster_shopbyproject/adminhtml_project_edit_tabs_description')->toHtml(),
        ));

        $this->addTab("product", array(
            "label" => Mage::helper("ghoster_shopbyproject")->__("Shop All Products"),
            "title" => Mage::helper("ghoster_shopbyproject")->__("Shop All Products"),
            "content" => $this->getLayout()->createBlock('ghoster_shopbyproject/adminhtml_project_edit_tabs_product')->toHtml(),
        ));

        $this->_updateActiveTab();
        Varien_Profiler::stop('project/tabs');
        return parent::_beforeToHtml();
    }

    protected function _updateActiveTab()
    {
        $tabId = $this->getRequest()->getParam('tab');
        if ($tabId) {
            $tabId = preg_replace("#{$this->getId()}_#", '', $tabId);
            if ($tabId) {
                $this->setActiveTab($tabId);
            }
        }
    }

}
