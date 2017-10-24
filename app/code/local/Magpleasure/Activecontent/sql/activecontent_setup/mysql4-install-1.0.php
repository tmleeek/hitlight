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

/** @var Mage_Core_Model_Resource_Setup $installer  */
$installer->startSetup();

$installer->run("
--
DROP TABLE IF EXISTS `{$this->getTable('mp_ac_content_store')}`;
DROP TABLE IF EXISTS `{$this->getTable('mp_ac_block_content')}`;
DROP TABLE IF EXISTS `{$this->getTable('mp_ac_block_store')}`;
DROP TABLE IF EXISTS `{$this->getTable('mp_ac_content')}`;
DROP TABLE IF EXISTS `{$this->getTable('mp_ac_block')}`;

CREATE TABLE IF NOT EXISTS `{$this->getTable('mp_ac_block')}` (
  `block_id` int(10) unsigned NOT NULL auto_increment,
  `name` VARCHAR(255) NOT NULL,
  `code` VARCHAR(255) NOT NULL,
  `width` VARCHAR(20) NOT NULL default '900',
  `height` VARCHAR(20) NOT NULL default '300',
  `status` INT(1) NOT NULL default '0',
  `type` VARCHAR(255),
  `easing` VARCHAR(255),
  `controls` VARCHAR(255),
  `pager` INT(1) unsigned,
  `autohide` INT(1) unsigned,
  `ticker` INT(1) unsigned,
  `slideshow` INT(1) unsigned,
  `duration` INT(10) unsigned,
  `direction` VARCHAR(255),
  `created_at` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`block_id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$this->getTable('mp_ac_content')}` (
  `content_id` int(10) unsigned NOT NULL auto_increment,
  `title` VARCHAR(255) NOT NULL,
  `short_title` VARCHAR(100),
  `status` INT(1) NOT NULL default '0',
  `content` TEXT,
  `background` VARCHAR (255),
  `created_at` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`content_id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$this->getTable('mp_ac_block_store')}` (
  `content_id` int(10) unsigned NOT NULL,
  `store_id` int(10) unsigned NOT NULL,
  KEY `FK_ACTIVECONTENT_CONTENT_INT_CONTENT_ID` (`content_id`),
  CONSTRAINT `FK_ACTIVECONTENT_CONTENT_INT_CONTENT_ID` FOREIGN KEY (`content_id`) REFERENCES `{$this->getTable('mp_ac_content')}` (`content_id`) ON DELETE CASCADE ON UPDATE CASCADE
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$this->getTable('mp_ac_block_content')}` (
  `link_id`  int(10) unsigned NOT NULL auto_increment,
  `block_id` int(10) unsigned NOT NULL,
  `content_id` int(10) unsigned NOT NULL,
  `sort_order` int(5),
  PRIMARY KEY  (`link_id`),
  KEY `FK_ACTIVECONTENT_LINK_INT_BLOCK_ID` (`block_id`),
  CONSTRAINT `FK_ACTIVECONTENT_LINK_INT_BLOCK_ID` FOREIGN KEY (`block_id`) REFERENCES `{$this->getTable('mp_ac_block')}` (`block_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  KEY `FK_ACTIVECONTENT_LINK_INT_CONTENT_ID` (`content_id`),
  CONSTRAINT `FK_ACTIVECONTENT_LINK_INT_CONTENT_ID` FOREIGN KEY (`content_id`) REFERENCES `{$this->getTable('mp_ac_content')}` (`content_id`) ON DELETE CASCADE ON UPDATE CASCADE
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$this->getTable('mp_ac_block_store')}` (
  `block_id` int(10) unsigned NOT NULL,
  `store_id` int(10) unsigned NOT NULL,
  KEY `FK_ACTIVECONTENT_BLOCK_INT_BLOCK_ID` (`block_id`),
  CONSTRAINT `FK_ACTIVECONTENT_BLOCK_INT_BLOCK_ID` FOREIGN KEY (`block_id`) REFERENCES `{$this->getTable('mp_ac_block')}` (`block_id`) ON DELETE CASCADE ON UPDATE CASCADE
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

$installer->endSetup();