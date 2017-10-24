<?php
/**
 * Unitech Corp.
 *
 * @category   Unitech
 * @package    Unitech_LandingPage
 * @version    0.0.1
 * @copyright  @copyright Copyright (c) 2015 Unitech Corp. (http://www.unitech.vn)
 */

class Unitech_LandingPage_Model_Mysql4_LandingPage_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        $this->_init('unitech_landingpage/landingPage');
        $this->_map['fields']['landingpage_id'] = 'main_table.landingpage_id';
    }

/**
     * Add stores column
     *
     * @return Unitech_LandingPage_Model_Mysql4_LandingPage_Collection
     */
    protected function _afterLoad()
    {
        parent::_afterLoad();
        if ($this->getFlag('add_stores_column')) {
            $this->_addStoresVisibility();
        }
        return $this;
    }

    /**
     * Join store table to result
     *
     * @return Unitech_LandingPage_Model_Mysql4_LandingPage_Collection
     */
    public function joinStoreTable()
    {
        $this->_select->join(
            array('store_table' => $this->getTable('unitech_landingpage/store')),
            'main_table.landingpage_id = store_table.landingpage_id',
            'store_id'
        );

        return $this;
    }

    /**
     * Set add stores column flag
     *
     * @return Unitech_LandingPage_Model_Mysql4_LandingPage_Collection
     */
    public function addStoresVisibility()
    {
        $this->setFlag('add_stores_column', true);
        return $this;
    }

    /**
     * Collect and set stores ids to each collection item
     * Used in landing page grid as Visible in column info
     *
     * @return Unitech_LandingPage_Model_Mysql4_LandingPage_Collection
     */
    protected function _addStoresVisibility()
    {
        $landingPageIds = $this->getColumnValues('landingpage_id');
        $landingPageStores = array();
        if (sizeof($landingPageIds)>0) {
            $select = $this->getConnection()->select()
                ->from($this->getTable('unitech_landingpage/store'), array('store_id', 'landingpage_id'))
                ->where('landingpage_id IN(?)', $landingPageIds);
            $landingPageRaw = $this->getConnection()->fetchAll($select);

            foreach ($landingPageRaw as $landingPage) {
                if (!isset($landingPageStores[$landingPage['landingpage_id']])) {
                    $landingPageStores[$landingPage['landingpage_id']] = array();
                }

                $landingPageStores[$landingPage['landingpage_id']][] = $landingPage['store_id'];
            }
        }

        foreach ($this as $item) {
            if (isset($landingPageStores[$item->getId()])) {
                $item->setStores($landingPageStores[$item->getId()]);
            } else {
                $item->setStores(array());
            }
        }

        return $this;
    }

   /**
     * Add Filter by store
     *
     * @param int|array $storeIds
     * @param bool $withAdmin
     * @return Unitech_LandingPage_Model_Mysql4_LandingPage_Collection
     */
    public function addStoreFilter($storeIds, $withAdmin = true)
    {
        if (!$this->getFlag('store_filter')) {
            if ($withAdmin) {
                $storeIds = array(0, $storeIds);
            }

            $this->getSelect()->join(
                array('store_table' => $this->getTable('unitech_landingpage/store')),
                'main_table.landingpage_id = store_table.landingpage_id',
                array()
            )
            ->where('store_table.store_id in (?)', $storeIds)
            //->group('main_table.landingpage_id')
            ;

            $this->setFlag('store_filter', true);
        }
        return $this;
    }
}