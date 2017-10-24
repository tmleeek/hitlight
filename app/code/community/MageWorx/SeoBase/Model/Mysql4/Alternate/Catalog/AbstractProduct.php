<?php
/**
 * MageWorx
 * MageWorx SeoBase Extension
 *
 * @category   MageWorx
 * @package    MageWorx_SeoBase
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

abstract class MageWorx_SeoBase_Model_Mysql4_Alternate_Catalog_AbstractProduct extends Mage_Core_Model_Mysql4_Abstract
{

    protected $_baseStoreUrls = array();

    /**
     * Init resource model (catalog/product)
     */
    protected function _construct()
    {
         $this->_init('catalog/product', 'entity_id');
         $this->_baseStoreUrls = Mage::helper('mageworx_seobase/alternate')->getBaseStoreUrls();
    }

    abstract public function getAllProductUrls($storeIds, $arrayTargetPath = false, $productId = false, $categoryId = false);

}

