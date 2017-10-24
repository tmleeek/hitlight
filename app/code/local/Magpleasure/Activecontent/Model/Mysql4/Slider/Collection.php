<?php
/**
 * MagPleasure Ltd.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE-CE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magpleasure.com/LICENSE-CE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento COMMUNITY edition
 * MagPleasure does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * Magpleasure does not provide extension support in case of
 * incorrect edition usage.
 * =================================================================
 *
 * @category   MagPleasure
 * @package    Magpleasure_Activecontent
 * @version    1.1.3
 * @copyright  Copyright (c) 2011-2014 MagPleasure Ltd. (http://www.magpleasure.com)
 * @license    http://www.magpleasure.com/LICENSE-CE.txt
 */

class Magpleasure_Activecontent_Model_Mysql4_Slider_Collection
    extends Magpleasure_Common_Model_Resource_Collection_Abstract
{
    protected $_store;

   	protected function _construct()
    {
		$this->_init('activecontent/slider');
	}

    protected function _beforeLoad()
    {
        if (!Mage::app()->isSingleStoreMode()){
            $this->_applyStoreFilter();
        }
        return parent::_beforeLoad();
    }


    protected function _afterLoad()
    {
        parent::_afterLoad();

        foreach ($this->_items as $item){
            $item
                ->load($item->getId())
                ->setSize($item->getWidth()."x".$item->getHeight())
                ;
        }

        return $this;
    }

    protected function _applyStoreFilter()
    {
        if ($store = $this->_store){

            if (!is_array($store)){
                $store = array($store);
            }

            $table = $this->_commonHelper()->getDatabase()->getTableName('mp_ac_slider_store');
            $idFieldName = "slider_id";
            $storesFilter = "'".implode("','", $store)."'";
            $this
                ->getSelect()
                ->joinInner(array('store'=>$table), "store.{$idFieldName} = main_table.{$idFieldName} AND store.store_id IN ({$storesFilter})", array())
                ->group("main_table.slider_id")
            ;
        }

        return $this;
    }

    public function addStoreFilter($store)
    {
        $this->_store = $store;
        return $this;
    }

    public function getSelectCountSql()
    {
        $getSliderIdsSelect = parent::getSelectCountSql();
        $getSliderIdsSelect->reset(Zend_Db_Select::COLUMNS);
        $getSliderIdsSelect->columns(array('slider_id'));

        $countSelect = new Zend_Db_Select($this->getResource()->getReadConnection());
        $tableName = $this->_commonHelper()->getDatabase()->getTableName('mp_ac_slider');
        $countSelect->from(array('mt'=>$tableName), array(new Zend_Db_Expr("COUNT(*)")));
        $countSelect->where(new Zend_Db_Expr(sprintf("`mt`.`slider_id` in (%s)", $getSliderIdsSelect->__toString())));

        return $countSelect;
    }
}