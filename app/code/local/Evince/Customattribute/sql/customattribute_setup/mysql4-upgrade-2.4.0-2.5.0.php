<?php
/**
* @author Evince Team
* @copyright Copyright (c) 2008-2015 Evince (http://www.evincedev.com/)
* @package Evince_Customerattr
*/
$installer = $this;

$installer->startSetup();

$installer->run("
    ALTER TABLE `{$this->getTable('eav/attribute_option')}` ADD `group_id` INT( 10 )  UNSIGNED NOT NULL ; 
");

$installer->endSetup(); 