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

$installer = $this;
$installer->startSetup();


# Transfer data to new structure
$lockKey = "magpleasure_activecontent_1.0.5_upgrade_lock";
/** @var Magpleasure_Activecontent_Helper_Data $helper */
$helper = Mage::helper('activecontent');
if (!$helper->getCommon()->getCache()->getPreparedValue($lockKey)) {
    $helper->getCommon()->getCache()->savePreparedValue($lockKey, true);

    # 1. Create new tables with optimized structure
    $installer->run("
--
DROP TABLE IF EXISTS `{$this->getTable('mp_ac_slider_store')}`;
DROP TABLE IF EXISTS `{$this->getTable('mp_ac_slide')}`;
DROP TABLE IF EXISTS `{$this->getTable('mp_ac_slider')}`;

CREATE TABLE IF NOT EXISTS `{$this->getTable('mp_ac_slider')}` (
  `slider_id` int(10) unsigned NOT NULL auto_increment,
  `name` VARCHAR(255) NOT NULL,
  `code` VARCHAR(255) NOT NULL,
  `width` VARCHAR(20) NOT NULL,
  `height` VARCHAR(20) NOT NULL,
  `status` INT(1) NOT NULL default '0',
  `type` VARCHAR(255),
  `easing` VARCHAR(255),
  `controls` VARCHAR(255),
  `pager` INT(1) unsigned,
  `autohide` INT(1) unsigned,
  `ticker` INT(1) unsigned,
  `slideshow` int(1) unsigned DEFAULT NULL,
  `slideshow_pause` int(10) DEFAULT NULL,
  `ticker_speed` int(10) DEFAULT NULL,
  `duration` INT(10) unsigned,
  `direction` VARCHAR(255),
  `created_at` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`slider_id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$this->getTable('mp_ac_slide')}` (
  `slide_id` int(10) unsigned NOT NULL auto_increment,
  `slider_id` int(10) unsigned NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `short_title` VARCHAR(100),
  `status` INT(1) NOT NULL default '0',
  `position` int(5),
  `content` TEXT,
  `background` VARCHAR (255),
  `created_at` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`slide_id`),
  CONSTRAINT `FK_ACTIVECONTENT_SLIDE_SLIDER` FOREIGN KEY (`slider_id`) REFERENCES `{$this->getTable('mp_ac_slider')}` (`slider_id`) ON DELETE CASCADE ON UPDATE CASCADE
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$this->getTable('mp_ac_slider_store')}` (
  `slider_id` int(10) unsigned NOT NULL,
  `store_id` int(10) unsigned NOT NULL,
  CONSTRAINT `FK_ACTIVECONTENT_SLIDER_STORE` FOREIGN KEY (`slider_id`) REFERENCES `{$this->getTable('mp_ac_slider')}` (`slider_id`) ON DELETE CASCADE ON UPDATE CASCADE
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

    # 2. Read all data from old tables
    $dbHelper = $helper->getCommon()->getDatabase();
    $read = $dbHelper->getReadConnection();

    $slidersTable = $dbHelper->getTableName('mp_ac_block');
    $slidesTable = $dbHelper->getTableName('mp_ac_content');
    $sliderSlideTable = $dbHelper->getTableName('mp_ac_block_content');
    $slideStoreTable = $dbHelper->getTableName('mp_ac_content_store');

    $select = $read->select();
    $select->from(array('slider' => $slidersTable));
    $sliders = $read->fetchAll($select);

    $slideIds = array();
    foreach ($sliders as &$slider) {

        $slider['slider_id'] = $sliderId = $slider['block_id'];

        # a. Read slides

        $slides = array();
        $select = $read->select();
        $select
            ->from(array('slides' => $slidesTable))
            ->joinInner(
                array('slide_slider' => $sliderSlideTable),
                "slide_slider.content_id = slides.content_id AND slide_slider.block_id = '{$sliderId}'",
                array("position" => "slide_slider.sort_order")
            )
            ->order("slide_slider.sort_order")
            ;

        $slides = $read->fetchAll($select);
        $slider['slides'] = $slides;

        $stores = array();
        if (count($slides)){

            # b. Read stores

            $slideIds = $read->fetchCol($select, 'content_id');

            $select = $read->select();
            $select
                ->from(array('store' => $slideStoreTable), array('store_id'))
                ->where('store.content_id IN (?)', $slideIds)
                ->group('store.store_id')
            ;

            $stores = $read->fetchCol($select, 'store_id');
        }

        if (!count($stores)){

            /** @var Mage_Core_Model_Resource_Store_Collection $storeCollection */
            $storeCollection = Mage::getModel('core/store')->getCollection();
            $storeCollection->addFieldToFilter('store_id', array('neq' => '0'));
            $stores = $storeCollection->getAllIds();
        }

        $slider['stores'] = $stores;
    }

    # 3. Save data to new table structure
    if (count($sliders)){

        $sliderKeys = array(
            'slider_id',
            'name',
            'code',
            'width',
            'height',
            'status',
            'type',
            'easing',
            'controls',
            'pager',
            'autohide',
            'ticker',
            'slideshow',
            'slideshow_pause',
            'ticker_speed',
            'duration',
            'direction',
            'created_at',
            'updated_at',
        );

        $slideKeys = array(
            'title',
            'short_title',
            'status',
            'background',
            'created_at',
            'updated_at',
            'position',
        );

        $sliderTable = $dbHelper->getTableName('mp_ac_slider');
        $sliderStoreTable = $dbHelper->getTableName('mp_ac_slider_store');
        $slideTable = $dbHelper->getTableName('mp_ac_slide');

        $allStoreIds = Mage::getModel('core/store')->getCollection()->getAllIds();

        $write = $dbHelper->getWriteConnection();
        $write->beginTransaction();

        foreach ($sliders as $sliderData){

            $insertData = array();
            foreach ($sliderKeys as $key){
                $insertData[$key] = isset($sliderData[$key]) ? $sliderData[$key] : null;
            }

            $dbHelper->insertIntoTable($sliderTable, $insertData);

            if (isset($sliderData['stores']) && is_array($sliderData['stores']) && count($sliderData['stores'])){

                foreach($sliderData['stores'] as $storeId){

                    if (in_array($storeId, $allStoreIds)){

                        $insertData = array(
                            'slider_id' => $sliderData['slider_id'],
                            'store_id' => $storeId,
                        );

                        $dbHelper->insertIntoTable($sliderStoreTable, $insertData);
                    }
                }
            }

            if (isset($sliderData['slides']) && is_array($sliderData['slides']) && count($sliderData['slides'])){

                foreach ($sliderData['slides'] as $slideData){

                    $insertData = array(
                        'slider_id' => $sliderData['slider_id'],
                        'content' => isset($slideData['content_value']) ? $slideData['content_value'] : $slideData['content'],
                    );

                    foreach ($slideKeys as $key){
                        $insertData[$key] = isset($slideData[$key]) ? $slideData[$key] : null;
                    }

                    $dbHelper->insertIntoTable($slideTable, $insertData);
                }
            }
        }

        $write->commit();
    }

    $installer->endSetup();
    $helper->getCommon()->getCache()->clearCachedData($lockKey);
}








