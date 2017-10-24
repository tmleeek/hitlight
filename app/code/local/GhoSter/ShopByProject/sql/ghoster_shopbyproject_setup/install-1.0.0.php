<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/1/16
 * Time: 10:51 AM
 */

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$this->run("--
    DROP TABLE IF EXISTS {$this->getTable('ghoster_shopbyproject/project')};
    CREATE TABLE {$this->getTable('ghoster_shopbyproject/project')} (
        `id` int(10) UNSIGNED NOT NULL auto_increment,
        `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
        `created_at` datetime NOT NULL,
        
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Shop By Project';
");


$this->run("--
    DROP TABLE IF EXISTS {$this->getTable('ghoster_shopbyproject/category')};
	CREATE TABLE {$this->getTable('ghoster_shopbyproject/category')} (
		`id` int(10) unsigned NOT NULL auto_increment,
		`entity_id` int(10) UNSIGNED NOT NULL,
		`category_id` int(10) UNSIGNED NOT NULL,
		
		PRIMARY KEY (`id`),
		KEY `SHOPBYPROJECT_ENTITY` (`entity_id`),
		CONSTRAINT `FK_SHOPBYPROJECT_ENTITY` FOREIGN KEY (`entity_id`) REFERENCES {$this->getTable('ghoster_shopbyproject/project')} (`id`) ON DELETE CASCADE ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Shop By Project Category';

");

$this->run("--
    DROP TABLE IF EXISTS {$this->getTable('ghoster_shopbyproject/commonproduct')};
	CREATE TABLE {$this->getTable('ghoster_shopbyproject/commonproduct')} (
		`id` int(10) unsigned NOT NULL auto_increment,
		`project_id` int(10) UNSIGNED NOT NULL,
		`entity_id` int(10) UNSIGNED NOT NULL,
		`product_id` int(10) UNSIGNED DEFAULT NULL,
		
		PRIMARY KEY (`id`),
		KEY `SHOPBYPROJECT_PROJECT_ENTITY` (`project_id`),
		KEY `SHOPBYPROJECT_CATEGORY_ENTITY` (`entity_id`),
		CONSTRAINT `FK_SHOPBYPROJECT_SHOPBYPROJECT_PROJECT_ENTITY` FOREIGN KEY (`project_id`) REFERENCES {$this->getTable('ghoster_shopbyproject/project')} (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
		CONSTRAINT `FK_SHOPBYPROJECT_CATEGORY_ENTITY` FOREIGN KEY (`entity_id`) REFERENCES {$this->getTable('ghoster_shopbyproject/category')} (`id`) ON DELETE CASCADE ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Shop By Project Common Product';

");

$installer->endSetup();
