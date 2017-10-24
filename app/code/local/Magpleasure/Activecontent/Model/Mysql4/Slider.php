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

class Magpleasure_Activecontent_Model_Mysql4_Slider extends Magpleasure_Common_Model_Resource_Abstract
{
   	protected function _construct()
    {
		$this->_init('activecontent/slider', 'slider_id');
        $this->setUseUpdateDatetimeHelper(true);
        $this->_addDataLink('store', 'stores', '_store', 'store_id');
	}

    /**
     * Helper
     * @return Magpleasure_Activecontent_Helper_Data
     */
    protected function _helper()
    {
        return Mage::helper('activecontent');
    }

    public function copySlides($fromId, $toId)
    {
        $slideTable = $this->_commonHelper()->getDatabase()->getTableName('mp_ac_slide');
        $read = $this->_commonHelper()->getDatabase()->getReadConnection();

        $select = $read->select();
        $select
            ->from(array('slide'=>$slideTable))
            ->where('slide.slider_id = ?', $fromId)
            ;

        $slidesData = $read->fetchAll($select);

        if (is_array($slidesData) && count($slidesData)){

            $write = $this->_commonHelper()->getDatabase()->getWriteConnection();
            $write->beginTransaction();

            foreach ($slidesData as $slideData){

                unset($slideData['slide_id']);
                $slideData['slider_id'] = $toId;
                $write->insert($slideTable, $slideData);
            }

            $write->commit();
        }

        return $this;
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
}