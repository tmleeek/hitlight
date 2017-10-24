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
class Magpleasure_Activecontent_Model_Mysql4_Slide extends Magpleasure_Common_Model_Resource_Abstract
{
    protected function _construct()
    {
        $this->_init('activecontent/slide', 'slide_id');
        $this->setUseUpdateDatetimeHelper(true);
    }

    /**
     * Helper
     * @return Magpleasure_Activecontent_Helper_Data
     */
    protected function _helper()
    {
        return Mage::helper('activecontent');
    }

    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        $timeZoneOffset = $this->_helper()->getTimeZoneOffset();

        foreach (array('display_from', 'display_to') as $key){

            if ($object->getData($key) && ($object->getData($key) !== '0000-00-00 00:00:00')) {

                $dataField = $object->getData($key);
                $dataField = new Zend_Date($dataField, Varien_Date::DATETIME_INTERNAL_FORMAT, Mage::app()->getLocale()->getLocaleCode());
                $dataField->addSecond($timeZoneOffset);
                $object->setData($key, $dataField->toString(Varien_Date::DATETIME_INTERNAL_FORMAT));
            } else {
                $object->unsetData($key);
            }
        }

        return parent::_afterLoad($object);
    }

    protected function _prepareCache(Mage_Core_Model_Abstract $object)
    {
        $this->_helper()->getCommon()->getCache()->cleanCachedData(
            array(
                'ACTIVE_CONTENT',
            )
        );

        # Invalidate Enterprise Cache if there's not comment update
        if ($this->_helper()->getCommon()->getMagento()->isEnteprise()){

            if (!$object->getIsCommentUpdateFlag()){
                Mage::app()->getCacheInstance()->invalidateType('full_page');
            }
        }

        return $this;
    }

    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        parent::_afterSave($object);
        $this->_prepareCache($object);

        return $this;
    }

    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        $timeZoneOffset = $this->_helper()->getTimeZoneOffset();
        $inputFormat = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);

        if ($fromData = $object->getData('display_from')){

            $fromData = new Zend_Date($fromData, null, Mage::app()->getLocale()->getLocaleCode());
            $fromData->subSecond($timeZoneOffset);
            $object->setData('display_from', $fromData->toString(Varien_Date::DATETIME_INTERNAL_FORMAT));
        } else {

            $object->setData('display_from', null);
        }

        if ($toData = $object->getData('display_to')){

            $toData = new Zend_Date($toData, null, Mage::app()->getLocale()->getLocaleCode());
            $toData->setHour(23)->setMinute(59)->setSecond(59);
            $toData->subSecond($timeZoneOffset);
            $object->setData('display_to', $toData->toString(Varien_Date::DATETIME_INTERNAL_FORMAT));
        } else {

            $object->setData('display_to', null);
        }

        return parent::_beforeSave($object);
    }
}