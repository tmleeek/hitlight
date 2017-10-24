<?php
/**
 * MageWorx
 * MageWorx SeoBase Extension
 *
 * @category   MageWorx
 * @package    MageWorx_SeoBase
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_SeoBase_Model_Mysql4_Alternate_Catalog_Product extends Mage_Core_Model_Mysql4_Abstract
{
    protected $_baseStoreUrls = array();

    /**
     * Init resource model (catalog/category)
     */
    protected function _construct()
    {
         $this->_init('catalog/product', 'entity_id');
         $this->_baseStoreUrls = Mage::helper('mageworx_seobase/alternate')->getBaseStoreUrls();
    }

    public function getAllProductUrls($storeIds, $arrayTargetPath = false, $productId = false, $categoryId = false)
    {
        $read          = $this->_getReadAdapter();
        $alternateUrls = array();
        if (!$productId) {
            $this->_select = $read->select()
                ->from($this->getTable('core/url_rewrite'),
                    array('store_id', 'product_id', 'request_path', 'target_path'))
                ->where('target_path IN (?)', $arrayTargetPath)
                ->where('store_id IN(?)', $storeIds)
                ->group(array('store_id', 'product_id'));
        }
        else {
            $this->_select = $read->select()
                ->from($this->getTable('core/url_rewrite'),
                    array('store_id', 'product_id', 'request_path', 'target_path'))
                ->where('target_path LIKE "%catalog/product/view/id/' . $productId . '%"')
                ->where('product_id=' . $productId)
                ->where('store_id IN(?)', $storeIds)
                ->group(array('store_id', 'product_id'));

                if ($categoryId === false) {
                    $this->_select->where('category_id IS NULL');
                } elseif (is_numeric($categoryId)) {
                    if (Mage::helper('mageworx_seobase')->useCategoriesPathInProductUrl()) {
                		$this->_select->where('category_id=' . $categoryId);
                	} else {
                		$this->_select->where('category_id IS NULL');
                	}
                }
        }

        $query = $read->query($this->_select);

        $result = $query->fetchAll();

        $products = array();

        foreach ($result as $row) {
            if (array_key_exists($row['product_id'], $products)) {
                $alternateUrls = array();
                if (isset($products[$row['product_id']]['alternateUrls'])) {
                    $alternateUrls = $products[$row['product_id']]['alternateUrls'];
                }
            }
            else {
                $products[$row['product_id']] = array();
                $alternateUrls                = array();
            }

            $alternateUrls[$row['store_id']] = $this->_baseStoreUrls[$row['store_id']] . $row['request_path'];
            $products[$row['product_id']]    = array('requestPath'   => $row['request_path'], 'alternateUrls' => $alternateUrls);
        }

        return $products;
    }
}