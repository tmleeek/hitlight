<?php
/**
 * MageWorx
 * File Downloads & Product Attachments Extension
 *
 * @category   MageWorx
 * @package    MageWorx_Downloads
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_Downloads_Model_Observer
{
    public function saveProductFiles(Varien_Event_Observer $observer)
    {
        $product = $observer->getProduct();
        $ids = $product->getDownloadsFilesIds();
        $productId = $product->getId();
        $relation = Mage::getSingleton('mageworx_downloads/relation');
        if ($productId && Mage::app()->getRequest()->getActionName() == 'save') {
            $relation->getResource()->deleteFilesProduct($productId);
        }
        if ($ids && $productId) {
            $ids = explode(',', $ids);
            $ids = array_unique($ids);
            foreach ($ids as $fileId) {
                $relation->setData(array(
                        'file_id' => $fileId,
                        'product_id' => $productId
                    )
                );
                $relation->save();
            }
        }
    }

    public function addFilesOnCategory($observer)
    {
        $helper = Mage::helper('mageworx_downloads');
        $block = $observer->getBlock();
        $isCategory = Mage::registry('current_category') && !Mage::registry('current_product');

        if (!($block instanceof Mage_Catalog_Block_Product_Price)
            || !$isCategory
            || !$helper->isEnableFilesOnCategoryPages())
        {
            return $this;
        }

        $toolbar = $block->getLayout()->getBlock('product_list_toolbar');
        $isGridMode = $toolbar && $toolbar->getCurrentMode() && $toolbar->getCurrentMode() == 'grid';

        $html = $observer->getTransport()->getHtml();
        $filesHtml = Mage::app()->getLayout()->createBlock('mageworx_downloads/product_link', '', array('id' => $block->getProduct()->getId(), 'is_category' => true, 'is_grid_mode' => $isGridMode))->toHtml();

        $observer->getTransport()->setHtml($html . $filesHtml);

        return $this;
    }

    public function addCustomerDownloadsTab($observer)
    {
        $block = $observer->getBlock();
        if (!($block instanceof Mage_Adminhtml_Block_Customer_Edit_Tabs)) {
            return $this;
        }

        $block->addTabAfter('downloads', array(
            'label'  => Mage::helper('mageworx_downloads')->__('File Downloads'),
            'class'  => 'ajax',
            'url'    => $block->getUrl('adminhtml/mageworx_downloads_files/customer', array('customer_id' => Mage::registry('current_customer')->getId()))
        ), 'tags');

        return $this;
    }
}
