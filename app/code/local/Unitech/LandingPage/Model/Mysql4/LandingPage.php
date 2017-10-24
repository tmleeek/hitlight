<?php
/**
 * Unitech Corp.
 *
 * @category   Unitech
 * @package    Unitech_LandingPage
 * @version    0.0.1
 * @copyright  @copyright Copyright (c) 2015 Unitech Corp. (http://www.unitech.vn)
 */

class Unitech_LandingPage_Model_Mysql4_LandingPage extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        // Note that the landingpage_id refers to the key field in your database table.
        $this->_init('unitech_landingpage/landingpage', 'landingpage_id');
    }

    /**
     * Process landingpage data before deleting
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Unitech_LandingPage_Model_Mysql_LandingPage
     */
    protected function _beforeDelete(Mage_Core_Model_Abstract $object)
    {
        $condition = array(
            'landingpage_id = ?'     => (int) $object->getId(),
        );

        $this->_getWriteAdapter()->delete($this->getTable('unitech_landingpage/store'), $condition);

        return parent::_beforeDelete($object);
    }

    /**
     * Process landing page data before saving
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Unitech_LandingPage_Model_Mysql_LandingPage
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (!$this->getIsUniqueLandingPageToStores($object)) {
            Mage::throwException(
                Mage::helper('unitech_landingpage')->__('A landing page URL key for specified store already exists.')
            );
        }

        if (!$this->isValidLandingPageIdentifier($object)) {
            Mage::throwException(
                Mage::helper('unitech_landingpage')->__(
                    'The landing page URL key contains capital letters or disallowed symbols.'
                )
            );
        }

        if ($this->isNumericLandingPageIdentifier($object)) {
            Mage::throwException(
                Mage::helper('unitech_landingpage')->__('The landing page URL key cannot consist only of numbers.')
            );
        }

        // modify create / update dates
        if ($object->isObjectNew() && !$object->hasCreationTime()) {
            $object->setCreationTime(Mage::getSingleton('core/date')->gmtDate());
        }

        $object->setUpdateTime(Mage::getSingleton('core/date')->gmtDate());

        return parent::_beforeSave($object);
    }

    /**
     * Retrieve load select with filter by identifier, store and activity
     *
     * @param string $identifier
     * @param int|array $store
     * @param int $isActive
     * @return Varien_Db_Select
     */
    protected function _getLoadByIdentifierSelect($identifier, $store, $isActive = null)
    {
        $select = $this->_getReadAdapter()->select()
            ->from(array('lp' => $this->getMainTable()))
            ->join(
                array('lps' => $this->getTable('unitech_landingpage/store')),
                'lp.landingpage_id = lps.landingpage_id',
                array()
            )
            ->where('lp.identifier = ?', $identifier)
            ->where('lps.store_id IN (?)', $store);

        if (!is_null($isActive)) {
            $select->where('lp.status = ?', $isActive);
        }

        return $select;
    }

    /**
     * Check for unique of identifier of landing page to selected store(s).
     *
     * @param Mage_Core_Model_Abstract $object
     * @return bool
     */
    public function getIsUniqueLandingPageToStores(Mage_Core_Model_Abstract $object)
    {
        if (Mage::app()->isSingleStoreMode() || !$object->hasStores()) {
            $stores = array(Mage_Core_Model_App::ADMIN_STORE_ID);
        } else {
            $stores = (array)$object->getData('stores');
        }
        $select = $this->_getLoadByIdentifierSelect($object->getData('identifier'), $stores);

        if ($object->getId()) {
            $select->where('lps.landingpage_id <> ?', $object->getId());
        }

        if ($this->_getWriteAdapter()->fetchRow($select)) {
            return false;
        }

        return true;
    }

    /**
     *  Check whether landing page identifier is numeric
     *
     * @date Wed Mar 26 18:12:28 EET 2008
     *
     * @param Mage_Core_Model_Abstract $object
     * @return bool
     */
    protected function isNumericLandingPageIdentifier(Mage_Core_Model_Abstract $object)
    {
        return preg_match('/^[0-9]+$/', $object->getData('identifier'));
    }

    /**
     *  Check whether landing page identifier is valid
     *
     *  @param    Mage_Core_Model_Abstract $object
     *  @return   bool
     */
    protected function isValidLandingPageIdentifier(Mage_Core_Model_Abstract $object)
    {
        return preg_match('/^[a-z0-9][a-z0-9_\/-]+(\.[a-z0-9_-]+)?$/', $object->getData('identifier'));
    }

    /**
     * Check if landing page identifier exist for specific store
     * return page id if page exists
     *
     * @param string $identifier
     * @param int $storeId
     * @return int
     */
    public function checkIdentifier($identifier, $storeId)
    {
        $stores = array(Mage_Core_Model_App::ADMIN_STORE_ID, $storeId);
        $select = $this->_getLoadByIdentifierSelect($identifier, $stores, 1);
        $select->reset(Zend_Db_Select::COLUMNS)
            ->columns('lp.landingpage_id')
            ->order('lps.store_id DESC')
            ->limit(1);

        return $this->_getReadAdapter()->fetchOne($select);
    }

    /**
     * Retrieves landing page page title from DB by passed identifier.
     *
     * @param string $identifier
     * @return string|false
     */
    public function getLandingPageTitleByIdentifier($identifier)
    {
        $stores = array(Mage_Core_Model_App::ADMIN_STORE_ID);
        if ($this->_store) {
            $stores[] = (int)$this->getStore()->getId();
        }

        $select = $this->_getLoadByIdentifierSelect($identifier, $stores);
        $select->reset(Zend_Db_Select::COLUMNS)
            ->columns('lp.title')
            ->order('lps.store_id DESC')
            ->limit(1);

        return $this->_getReadAdapter()->fetchOne($select);
    }

    /**
     * Retrieves landing page page title from DB by passed id.
     *
     * @param string $id
     * @return string|false
     */
    public function getLandingPageTitleById($id)
    {
        $adapter = $this->_getReadAdapter();

        $select  = $adapter->select()
            ->from($this->getMainTable(), 'title')
            ->where('landingpage_id = :landingpage_id');

        $binds = array(
            'landingpage_id' => (int) $id
        );

        return $adapter->fetchOne($select, $binds);
    }

    /**
     * Retrieves landingpage identifier from DB by passed id.
     *
     * @param string $id
     * @return string|false
     */
    public function getLandingPageIdentifierById($id)
    {
        $adapter = $this->_getReadAdapter();

        $select  = $adapter->select()
            ->from($this->getMainTable(), 'identifier')
            ->where('landingpage_id = :landingpage_id');

        $binds = array(
            'landingpage_id' => (int) $id
        );

        return $adapter->fetchOne($select, $binds);
    }

    /**
     * Initialize unique fields
     *
     * @return Mage_Core_Model_Mysql4_Abstract
     */
    protected function _initUniqueFields()
    {
        $this->_uniqueFields = array(array(
            'field' => 'title',
            'title' => Mage::helper('unitech_landingpage')->__('Landing Page with the same title')
        ));
        return $this;
    }

    /**
     * Load store Ids array
     *
     * @param Unitech_LandingPage_Model_LandingPage $object
     */
    public function loadStoreIds(Unitech_LandingPage_Model_LandingPage $object)
    {
        $landingPageId   = $object->getId();
        $storeIds = array();
        if ($landingPageId) {
            $storeIds = $this->lookupStoreIds($landingPageId);
        }
        $object->setStoreIds($storeIds);
    }

    /**
     * Get store ids to which specified item is assigned
     *
     * @param int $id
     * @return array
     */
    public function lookupStoreIds($id)
    {
        return $this->_getReadAdapter()->fetchCol(
            $this->_getReadAdapter()->select()
                ->from($this->getTable('unitech_landingpage/store'), 'store_id')
                ->where("{$this->getIdFieldName()} = :id_field"),
            array(':id_field' => $id)
        );
    }

    /**
     * Delete current landingpage from the table unitech_landingpage_store and then
     * insert to update "landingpage to store" relations
     *
     * @param Mage_Core_Model_Abstract $object
     */
    public function saveLandingPageStore(Mage_Core_Model_Abstract $object)
    {
        /** stores */
        $deleteWhere = $this->_getReadAdapter()->quoteInto('landingpage_id = ?', $object->getId());
        $this->_getReadAdapter()->delete($this->getTable('unitech_landingpage/store'), $deleteWhere);

        foreach ($object->getStoreIds() as $storeId) {
            $landingPageStoreData = array(
            'landingpage_id'   => $object->getId(),
            'store_id'  => $storeId
            );
            $this->_getWriteAdapter()->insert($this->getTable('unitech_landingpage/store'), $landingPageStoreData);
            if ($storeId === '0') {
                break;
            }
        }
    }
    /*
     * It will call method _beforeSave()" to validate data
     */
    public function validateImportData(Mage_Core_Model_Abstract $object)
    {
        $this->_beforeSave($object);
    }
}