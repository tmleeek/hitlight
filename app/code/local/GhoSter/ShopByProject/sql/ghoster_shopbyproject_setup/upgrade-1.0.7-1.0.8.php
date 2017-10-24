<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/10/16
 * Time: 3:42 PM
 */

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$this->run("--
    DROP TABLE IF EXISTS {$this->getTable('ghoster_shopbyproject/instruction')};
    CREATE TABLE {$this->getTable('ghoster_shopbyproject/instruction')} (
        `id` int(10) UNSIGNED NOT NULL auto_increment,
        `entity_id` int(10) UNSIGNED NOT NULL,
        `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
        `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `data` text NOT NULL,
        
        PRIMARY KEY (`id`),
        KEY `SHOPBYPROJECT_INSTRUCTION_ENTITY` (`entity_id`),
        CONSTRAINT `FK_SHOPBYPROJECT_INSTRUCTION_ENTITY` FOREIGN KEY (`entity_id`) REFERENCES {$this->getTable('cms/block')} (`block_id`) ON DELETE CASCADE ON UPDATE CASCADE

    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Shop By Project Instruction Block Generator';
");
