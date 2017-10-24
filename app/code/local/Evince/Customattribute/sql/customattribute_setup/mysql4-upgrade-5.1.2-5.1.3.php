<?php
/**
* @author Evince Team
* @package Evince_Customattribute
*/
$installer = $this;

$installer->startSetup();

$installer->run("
    UPDATE `{$this->getTable('eav_attribute')}` SET `backend_type`='varchar' WHERE `frontend_input`='file' AND `backend_type`='static';
");

$installer->endSetup();