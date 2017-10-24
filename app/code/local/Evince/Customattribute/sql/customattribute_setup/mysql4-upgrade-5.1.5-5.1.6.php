<?php
/**
* @author Evince Team
* @package Evince_Customattribute
*/
$installer = $this;

$installer->startSetup();

$installer->run("
    ALTER TABLE `{$this->getTable('customer/eav_attribute')}` ADD `account_filled` TINYINT( 1 ) UNSIGNED NOT NULL ;
    ALTER TABLE `{$this->getTable('customer/eav_attribute')}` ADD `billing_filled` TINYINT( 1 ) UNSIGNED NOT NULL ;
");

$installer->endSetup(); 