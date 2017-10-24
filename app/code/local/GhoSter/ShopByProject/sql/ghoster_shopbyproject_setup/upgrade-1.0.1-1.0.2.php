<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/11/16
 * Time: 11:24 AM
 */

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$this->run("--
    DROP TABLE IF EXISTS {$this->getTable('ghoster_shopbyproject/slide')};
	CREATE TABLE {$this->getTable('ghoster_shopbyproject/slide')} (
		`slide_id` int(10) unsigned NOT NULL auto_increment,
		`project_id` int(10) UNSIGNED NOT NULL,
		`entity_id` int(10) UNSIGNED NOT NULL,
		`slide_image` varchar(300) NOT NULL default '',
        `slide_url` varchar(100) NOT NULL default '',

		PRIMARY KEY (`slide_id`),
		KEY `SHOPBYPROJECT_PROJECT_SLIDE_ENTITY` (`project_id`),
		KEY `SHOPBYPROJECT_CATEGORY_SLIDE_ENTITY` (`entity_id`),
		CONSTRAINT `FK_SHOPBYPROJECT_PROJECT_SLIDE_ENTITY` FOREIGN KEY (`project_id`) REFERENCES {$this->getTable('ghoster_shopbyproject/project')} (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
		CONSTRAINT `FK_SHOPBYPROJECT_CATEGORY_SLIDE_ENTITY` FOREIGN KEY (`entity_id`) REFERENCES {$this->getTable('ghoster_shopbyproject/category')} (`id`) ON DELETE CASCADE ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Shop By Project Slide';

");


$installer->endSetup();
