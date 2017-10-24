<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/11/16
 * Time: 2:13 PM
 */

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$this->run("--
    DROP TABLE IF EXISTS {$this->getTable('ghoster_shopbyproject/product')};
	CREATE TABLE {$this->getTable('ghoster_shopbyproject/product')} (
		`id` int(10) unsigned NOT NULL auto_increment,
		`entity_id` int(10) UNSIGNED NOT NULL,
		`project_id` int(10) UNSIGNED NOT NULL,
        `product_ids` varchar(300) NOT NULL default '',

		PRIMARY KEY (`id`),
		KEY `SHOPBYPROJECT_PROJECT_SHOPALLPRODUCTS_ENTITY` (`project_id`),
		KEY `SHOPBYPROJECT_CATEGORY_SHOPALLPRODUCTS_ENTITY` (`entity_id`),
		CONSTRAINT `FK_SHOPBYPROJECT_PROJECT_SHOPALLPRODUCTS_ENTITY` FOREIGN KEY (`project_id`) REFERENCES {$this->getTable('ghoster_shopbyproject/project')} (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
		CONSTRAINT `FK_SHOPBYPROJECT_CATEGORY_SHOPALLPRODUCTS_ENTITY` FOREIGN KEY (`entity_id`) REFERENCES {$this->getTable('ghoster_shopbyproject/category')} (`id`) ON DELETE CASCADE ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Shop By Project Products';

");

$installer->endSetup();
