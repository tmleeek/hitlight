<?php
/**
 * Unitech Corp.
 *
 * @category   Unitech
 * @package    Unitech_LandingPage
 * @version    0.0.1
 * @copyright  @copyright Copyright (c) 2015 Unitech Corp. (http://www.unitech.vn)
 */

/* @var $installer Unitech_LandingPage_Model_Mysql4_Setup */
$installer = $this;

$installer->startSetup();

$installer->run(
    "/* Create table 'unitech_landingpage/landingpage' */

-- DROP TABLE IF EXISTS {$this->getTable('unitech_landingpage/landingpage')};
CREATE TABLE {$this->getTable('unitech_landingpage/landingpage')} (
    `landingpage_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Landing Page Id',
    `title` varchar(255) DEFAULT NULL COMMENT 'Title',
    `identifier` varchar(255) DEFAULT NULL COMMENT 'Identifier',
    `status` smallint(6) NOT NULL COMMENT 'Status',
    `keywords` varchar(255) DEFAULT NULL COMMENT 'Keywords',
    `part_numbers` text COMMENT 'Part Numbers',
    `short_description` text NOT NULL COMMENT 'Short Description',
    `description` text NOT NULL COMMENT 'Description',
    `meta_keywords` text COMMENT 'Meta Keywords',
    `meta_description` text COMMENT 'Meta Description',
    `sort_order` smallint(6) DEFAULT NULL COMMENT 'Sort Order',
    `creation_time` datetime DEFAULT NULL COMMENT 'Creation Time',
    `update_time` datetime DEFAULT NULL COMMENT 'Update Time',
    PRIMARY KEY (`landingpage_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Unitech Landing Page';

/*  Create table 'unitech_landingpage/store' */

-- DROP TABLE IF EXISTS {$this->getTable('unitech_landingpage/store')};
CREATE TABLE {$this->getTable('unitech_landingpage/store')} (
    `landingpage_id` int(10) unsigned NOT NULL COMMENT 'Landing Page Id',
    `store_id` smallint(5) unsigned NOT NULL COMMENT 'Store Id',
    KEY `IDX_UNITECH_LANDINGPAGE_STORE_LANDINGPAGE_ID` (`landingpage_id`),
    KEY `IDX_UNITECH_LANDINGPAGE_STORE_STORE_ID` (`store_id`),
    CONSTRAINT `FK_UNITECH_LANDINGPAGE_STORE_LP_ID_UNITECH_LANDINGPAGE_LP_ID` FOREIGN KEY (`landingpage_id`) 
    REFERENCES {$this->getTable('unitech_landingpage/landingpage')} (`landingpage_id`) 
    ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_UNITECH_LANDINGPAGE_STORE_STORE_ID_CORE_STORE_STORE_ID` FOREIGN KEY (`store_id`) 
    REFERENCES {$this->getTable('core_store')} (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Unitech Landing Page Store';"
);
$installer->endSetup();  