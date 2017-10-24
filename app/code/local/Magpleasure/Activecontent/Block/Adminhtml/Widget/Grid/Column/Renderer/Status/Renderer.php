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

class Magpleasure_Activecontent_Block_Adminhtml_Widget_Grid_Column_Renderer_Status_Renderer
    extends Mage_Adminhtml_Block_Template
{
    protected $_nowDate;

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('mp_activecontent/widget/grid/column/renderer/status.phtml');
    }

    /**
     * Helper
     * @return Magpleasure_Activecontent_Helper_Data
     */
    protected function _helper()
    {
        return Mage::helper('activecontent');
    }

    public function isEnabled()
    {
        return $this->getData('status') == Magpleasure_Activecontent_Model_Slide::STATUS_ENABLED;
    }

    public function getFromDate()
    {
        if ($this->getData('display_from')){

            $fromDate = new Zend_Date($this->getData('display_from'), Varien_Date::DATETIME_INTERNAL_FORMAT);
            return $fromDate;
        }

        return false;
    }

    public function getToDate()
    {
        if ($this->getData('display_to')){

            $toDate = new Zend_Date($this->getData('display_to'), Varien_Date::DATETIME_INTERNAL_FORMAT);
            return $toDate;
        }

        return false;
    }

    public function getNowDate()
    {
        if (!$this->_nowDate){
            $this->_nowDate = new Zend_Date();
        }
        return $this->_nowDate;
    }

    public function isVisible()
    {
        return (
            ((!$this->getFromDate() && !$this->getToDate()) ? true : false) ||
            (($this->getFromDate() && !$this->getToDate()) ? ($this->getFromDate() <= $this->getNowDate()) : false) ||
            ((!$this->getFromDate() && $this->getToDate()) ? ($this->getNowDate() <= $this->getToDate()) : false) ||
            (($this->getFromDate() && $this->getToDate()) ? (($this->getFromDate() <= $this->getNowDate()) && ($this->getNowDate() <= $this->getToDate())) : false)
        );
    }

    public function willItHidden()
    {
        return $this->getToDate() && ($this->getNowDate() <= $this->getToDate());
    }

    public function isInFuture()
    {
        return $this->getFromDate() && ($this->getNowDate() < $this->getFromDate());
    }

    public function isInPast()
    {
        return $this->getToDate() && ($this->getToDate() < $this->getNowDate());
    }

    public function getHiddenSinceDescription()
    {
        $toDate = $this->getToDate()->addSecond($this->_helper()->getTimeZoneOffset())->addSecond(1);
        if ($toDate){

            $format = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
            return $toDate->toString($format);
        }
        return false;
    }

    public function getWillBeHiddenInDescription()
    {
        $toDate = $this->getToDate()->addSecond($this->_helper()->getTimeZoneOffset())->addSecond(1);
        if ($toDate){

            $format = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
            return $toDate->toString($format);
        }
        return false;
    }

    public function getWillBePublishedInDescription()
    {
        $fromDate = $this->getFromDate()->addSecond($this->_helper()->getTimeZoneOffset());
        if ($fromDate){

            $format = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
            return $fromDate->toString($format);
        }
        return false;
    }
}
