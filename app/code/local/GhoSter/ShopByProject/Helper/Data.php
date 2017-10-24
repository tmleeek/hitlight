<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/1/16
 * Time: 10:51 AM
 */
class GhoSter_ShopByProject_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * @param $sbp_category_id
     * @return GhoSter_ShopByProject_Model_Category
     */
    public function getShopByProjectCategory($sbp_category_id)
    {

        $sbp_category = Mage::getModel('ghoster_shopbyproject/category')->load($sbp_category_id);
        return $sbp_category;

    }

    /**
     * @param $_category_id
     * @return string
     */
    public function getCategoryName($_category_id)
    {
        return Mage::getModel('catalog/category')->load($_category_id)->getName();
    }

    /**
     * @param $_product_id
     * @return string
     */
    public function getProductName($_product_id)
    {
        return Mage::getModel('catalog/product')->load($_product_id)->getName();
    }

    /**
     * Get CommonProducts By Category ID
     *
     * @param $_category_id
     * @return Mage_Catalog_Model_Resource_Product_Collection|null
     * @throws Mage_Core_Exception
     */
    public function getCommonProducts($_category_id)
    {
        if ($_category_id) {
            $collection = Mage::getModel('catalog/product')
                ->getCollection()
                ->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id = entity_id', null, 'left')
                ->addAttributeToSelect('*')
                ->addAttributeToFilter('category_id', $_category_id);

            return $collection;
        }

        return null;
    }

    /**
     * @param $_project_id
     * @return array
     */
    public function getSelectedCategories($_project_id)
    {
        $data = [];
        $collection = Mage::getModel('ghoster_shopbyproject/category')->getCollection()
            ->addFieldToSelect('*')
            ->addFieldToFilter('entity_id', $_project_id);

        foreach ($collection as $category) {
            $data[] = $category->getData('category_id');
        }
        return $data;

    }


    /**
     * @param $_project_id
     * @return array
     */
    public function getSelectedProjectCategories($_project_id)
    {
        $data = [];
        $collection = Mage::getModel('ghoster_shopbyproject/category')->getCollection()
            ->addFieldToSelect('*')
            ->addFieldToFilter('entity_id', $_project_id);

        foreach ($collection as $category) {
            $data[] = $category->getId();
        }
        return $data;

    }


    /**
     * Get Selected Common Product by Category Id
     *
     * @param $_category_id
     * @param $project_id
     * @return array
     */
    public function getSelectedCommonProducts($_category_id, $project_id)
    {

        $selected_category_ids = [];

        if ($project_id) {
            $selected_categories = Mage::getModel('ghoster_shopbyproject/category')->getCollection()
                ->addFieldToSelect('*')
                ->addFieldToFilter('category_id', $_category_id);

            foreach ($selected_categories as $selected_category) {
                $selected_category_ids[] = $selected_category->getId();
            }

            $data = [];

            $collection = Mage::getModel('ghoster_shopbyproject/commonproduct')->getCollection()
                ->addFieldToSelect('*')
                ->addFieldToFilter('project_id', $project_id)
                ->addFieldToFilter('entity_id', array('in' => $selected_category_ids));

            foreach ($collection as $common_product) {
                $data[] = $common_product->getData('product_id');
            }

            return $data;

        } else {

            return null;

        }

    }

    /**
     * Get get Shop All Products by Category Id
     *
     * @param $category_id
     * @param $project_id
     * @return array
     */
    public function getShopAllProducts($category_id, $project_id)
    {

        $selected_category_ids = [];

        if ($project_id) {
            $selected_categories = Mage::getModel('ghoster_shopbyproject/category')->getCollection()
                ->addFieldToSelect('*')
                ->addFieldToFilter('category_id', $category_id);

            foreach ($selected_categories as $selected_category) {
                $selected_category_ids[] = $selected_category->getId();
            }

            $product = Mage::getModel('ghoster_shopbyproject/shopallproducts')->getCollection()
                ->addFieldToSelect('*')
                ->addFieldToFilter('project_id', $project_id)
                ->addFieldToFilter('entity_id', array('in' => $selected_category_ids))
                ->getFirstItem();

            return $product->getData('product_skus');

        } else {

            return null;

        }
    }


    public function getHowToDescriptions($category_id, $project_id)
    {

        $data = [];

        if ($project_id) {
            $sbp_category = Mage::getModel('ghoster_shopbyproject/category')->getCollection()
                ->addFieldToSelect('*')
                ->addFieldToFilter('category_id', $category_id)
                ->addFieldToFilter('entity_id', $project_id)
                ->getFirstItem();

            $data['how_to'] = $sbp_category->getData('how_to');

            $data['summary'] = $sbp_category->getData('summary');

            $data['instruction_block_id'] = $sbp_category->getData('instruction_block_id');

            return $data;

        } else {

            return null;

        }
    }


    /**
     * Get Instruction CMS Blocks
     *
     * @return object
     */
    public function getInstructionCMSBlocks()
    {
        $collection = Mage::getModel('cms/block')->getCollection();
        $collection->addFieldToFilter('use_instruction', 1);
        $collection->getSelect()->join( array('instruction'=> Mage::getSingleton('core/resource')->getTableName('ghoster_shopbyproject/instruction')), 'instruction.entity_id = main_table.block_id', array('instruction_id'=>'instruction.id'));

        return $collection;
    }


    public function getInstructionCMSBlocksOptionArray()
    {
        $data = [];

        $blocks = $this->getInstructionCMSBlocks();

        foreach ($blocks as $key=>$block) {
            $data[$key]['label'] = $block->getTitle();
            $data[$key]['value'] = $block->getBlockId();
        }


        return $data;
    }

}
