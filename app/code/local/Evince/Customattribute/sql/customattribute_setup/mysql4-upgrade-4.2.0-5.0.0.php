<?php
/**
* @author Evince Team

* @package Evince_Customattribute
*/
$installer = $this;

$installer->startSetup();

$installer->run("
    ALTER TABLE `{$this->getTable('customer/eav_attribute')}` ADD `file_size` SMALLINT( 5 ) UNSIGNED NOT NULL ;
    ALTER TABLE `{$this->getTable('customer/eav_attribute')}` ADD `file_types` VARCHAR( 255 ) NOT NULL ;
    ALTER TABLE `{$this->getTable('customer/eav_attribute')}` ADD `file_dimentions` VARCHAR( 255 ) NOT NULL ;
");

$installer->endSetup();