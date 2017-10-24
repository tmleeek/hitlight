<?php
/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/22/16
 * Time: 5:08 PM
 */

$installer = new Mage_Eav_Model_Entity_Setup($this->_resourceName);
$installer->startSetup();

$installer->run("
    alter table {$installer->getTable('cms/page')}
    add column cyberfision_banner VARCHAR(255) null 
");

$installer->endSetup();