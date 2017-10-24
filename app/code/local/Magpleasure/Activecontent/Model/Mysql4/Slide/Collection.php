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

class Magpleasure_Activecontent_Model_Mysql4_Slide_Collection
    extends Magpleasure_Common_Model_Resource_Collection_Abstract
{
    protected $_loadStores = false;

   	protected function _construct()
    {
		$this->_init('activecontent/slide');
	}

    public function sortSlides()
    {
        $this->setOrder('position', self::SORT_ORDER_ASC);
        return $this;
    }

    public function setLoadStores($value)
    {
        $this->_loadStores = $value;
        return $this;
    }

    /**
     * Max Position in Collection
     *
     * @return int
     */
    public function getMaxPosition()
    {
        $maxSelect = clone $this->getSelect();
        $maxSelect
            ->reset(Zend_Db_Select::ORDER)
            ->reset(Zend_Db_Select::LIMIT_COUNT)
            ->reset(Zend_Db_Select::LIMIT_OFFSET)
            ->reset(Zend_Db_Select::COLUMNS)
            ->columns('position')
            ->order("position DESC")
            ->limit(1)
        ;

        $read = $this->_commonHelper()->getDatabase()->getReadConnection();
        if ($maxPosition = $read->fetchOne($maxSelect)){
            return (int)$maxPosition;
        }

        return 0;
    }

    public function addVisibilityFilter()
    {
        $nowDate = new Zend_Date();
        $nowIso = $nowDate->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);

        $whereSentence =
            "(IF( (`main_table`.`display_from` IS NULL AND `main_table`.`display_to` IS NULL), TRUE, FALSE) OR ".
            "IF( (`main_table`.`display_from` IS NOT NULL AND `main_table`.`display_to` IS NULL), (`main_table`.`display_from` <= '{$nowIso}'), FALSE) OR ".
            "IF( (`main_table`.`display_from` IS NULL AND `main_table`.`display_to` IS NOT NULL), ('{$nowIso}' <= `main_table`.`display_to`), FALSE) OR ".
            "IF( (`main_table`.`display_from` IS NOT NULL AND `main_table`.`display_to` IS NOT NULL), ((`main_table`.`display_from` <= '{$nowIso}') AND ('{$nowIso}' <= `main_table`.`display_to`)), FALSE))";

        $this->getSelect()->where(new Zend_Db_Expr($whereSentence));
        $this
            ->addFieldToFilter('status', Magpleasure_Activecontent_Model_Slide::STATUS_ENABLED)
            ;

        return $this;
    }

    public function addInvisibilityFilter()
    {
        $nowDate = new Zend_Date();
        $nowIso = $nowDate->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);

        $whereSentence =
            "(IF( (`main_table`.`display_from` IS NOT NULL AND `main_table`.`display_to` IS NULL), (`main_table`.`display_from` >= '{$nowIso}'), FALSE) OR ".
            "IF( (`main_table`.`display_from` IS NULL AND `main_table`.`display_to` IS NOT NULL), ('{$nowIso}' >= `main_table`.`display_to`), FALSE) OR ".
            "IF( (`main_table`.`display_from` IS NOT NULL AND `main_table`.`display_to` IS NOT NULL), ((`main_table`.`display_from` >= '{$nowIso}') OR ('{$nowIso}' >= `main_table`.`display_to`)), FALSE))";

        $this->getSelect()->where(new Zend_Db_Expr($whereSentence));
        $this
            ->addFieldToFilter('status', Magpleasure_Activecontent_Model_Slide::STATUS_ENABLED)
        ;

        return $this;
    }
}