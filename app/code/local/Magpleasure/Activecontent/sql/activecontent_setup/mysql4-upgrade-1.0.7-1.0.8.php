<?php
/**
 * MagPleasure Ltd.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE-CE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magpleasure.com/LICENSE-CE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento COMMUNITY edition
 * MagPleasure does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * Magpleasure does not provide extension support in case of
 * incorrect edition usage.
 * =================================================================
 *
 * @category   MagPleasure
 * @package    Magpleasure_Activecontent
 * @version    1.1.3
 * @copyright  Copyright (c) 2011-2014 MagPleasure Ltd. (http://www.magpleasure.com)
 * @license    http://www.magpleasure.com/LICENSE-CE.txt
 */

$installer = $this;
$installer->startSetup();

$installer->run("

ALTER TABLE `{$this->getTable('mp_ac_slider')}`
  ADD COLUMN `use_size` SMALLINT(1) UNSIGNED DEFAULT 1  NOT NULL AFTER `code`,
  CHANGE `width` `width` VARCHAR(20) CHARSET utf8 COLLATE utf8_general_ci NULL,
  ADD COLUMN `width_type` VARCHAR(10) DEFAULT 'px' NULL AFTER `width`,
  CHANGE `height` `height` VARCHAR(20) CHARSET utf8 COLLATE utf8_general_ci NULL,
  ADD COLUMN `height_type` VARCHAR(10) DEFAULT 'px' NULL AFTER `height`;

    ");
$installer->endSetup();

