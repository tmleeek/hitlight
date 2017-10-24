<?php

class GhoSter_CategorySlider_Model_Observer{
    public function adminhtmlCatalogCategoryTabs($observer){
        /* @var $tabs Mage_Adminhtml_Block_Catalog_Category_Tabs */
        $tabs = $observer->getEvent()->getTabs();
        $tabs->addTab('slider_section', array(
            'label'     => Mage::helper('ghoster_categoryslider')->__('Slider Settings'),
            'content'   => $tabs->getLayout()->createBlock('ghoster_categoryslider/adminhtml_catalog_category_tab_slider')->toHtml()
        ));
    }

    public function catalogCategoryPrepareSave($observer){
        $category = $observer->getEvent()->getCategory();
        /* @var $category Mage_Catalog_Model_Category */
        $request = $observer->getEvent()->getRequest();
        /* @var $request Mage_Core_Controller_Request_Http */

        $images = $request->getParam('slider_images');
		$slideUrl = $request->getParam('slider_url');
        $object = array();

        if (is_array($images)){
            foreach ($images as $key => $image){
                $object[] = array(
                    'uri' => parse_url($image)['path'],
                    'slider_url' => $slideUrl[$key]
                );
            }
        }

        $category->setData('slider_params', Mage::helper('core')->jsonEncode($object));
        $category->save();
    }
}