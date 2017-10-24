<?php
/**
 * Unitech Corp.
 *
 * @category   Unitech
 * @package    Unitech_LandingPage
 * @version    0.0.1
 * @copyright  @copyright Copyright (c) 2015 Unitech Corp. (http://www.unitech.vn)
 */

/* @var $installer Unitech_LandingPage_Model_Mysql4_Setup */
$installer = $this;

$installer->startSetup();

$installer->run(
    "
	ALTER TABLE {$this->getTable('unitech_landingpage/landingpage')}
	ADD COLUMN `other_link_text` MEDIUMTEXT NULL COMMENT 'Other Link Text' AFTER `update_time`,
	ADD COLUMN `other_link` MEDIUMTEXT NULL COMMENT 'Other Links' AFTER `other_link_text`;"
);
$installer->endSetup();  