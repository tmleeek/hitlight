<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/12/16
 * Time: 3:45 PM
 */
class NextBits_Wholesale_Model_System_Config_Source_CMSPage
{
    public function toOptionArray()
    {
        $pages = [];
        $helper = Mage::helper('wholesale');

        $collection = Mage::getModel('cms/page')->getCollection();
        /* @var $page Mage_Cms_Model_Page */
        foreach ($collection as $page) {
            $pages[$page->getId()]['value'] = $page->getId();
            $pages[$page->getId()]['label'] = $page->getTitle();
        }

        return $pages;
    }
}
