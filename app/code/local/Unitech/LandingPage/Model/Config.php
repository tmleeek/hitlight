<?php
/**
 * Unitech Corp.
 *
 * @category   Unitech
 * @package    Unitech_LandingPage
 * @version    0.0.1
 * @copyright  @copyright Copyright (c) 2015 Unitech Corp. (http://www.unitech.vn)
 */

class Unitech_LandingPage_Model_Config extends Mage_Eav_Model_Config
{
    const XML_PATH_LIST_DEFAULT_SORT_BY     = 'unitech_landingpage/frontend/default_sort_by';

    protected $_storeId = null;

    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('unitech_landingpage/config');
    }

    /**
     * Set store id
     *
     * @param integer $storeId
     * @return Mage_Catalog_Model_Config
     */
    public function setStoreId($storeId)
    {
        $this->_storeId = $storeId;
        return $this;
    }

    /**
     * Return store id, if is not set return current app store
     *
     * @return integer
     */
    public function getStoreId()
    {
        if ($this->_storeId === null) {
            return Mage::app()->getStore()->getId();
        }
        return $this->_storeId;
    }

    /**
     * Retrieve Attributes Used for Sort by as array
     * key = code, value = name
     *
     * @return array
     */
    public function getAttributeUsedForSortByArray()
    {
        $options = array(
            'sort_order'  => Mage::helper('unitech_landingpage')->__('Position'),
            'title'       => Mage::helper('unitech_landingpage')->__('Name'),
        );

        return $options;
    }

    /**
     * Retrieve Landing Page List Default Sort By
     *
     * @param mixed $store
     * @return string
     */
    public function getLandingPageListDefaultSortBy($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_LIST_DEFAULT_SORT_BY, $store);
    }
}
