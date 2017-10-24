<?php
/**
* @author Evince Team
* @copyright Copyright (c) 2008-2015 Evince (http://www.evincedev.com/)
* @package Evince_Customerattr
*/
$installer = $this;

$installer->startSetup();

$installer->run("
    ALTER TABLE `{$this->getTable('customer/eav_attribute')}` ADD `used_in_order_grid` TINYINT( 1 ) UNSIGNED NOT NULL ;
");

$installer->endSetup(); 