<?php
/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at http://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   Trigger Email Suite
 * @version   1.0.1
 * @revision  156
 * @copyright Copyright (C) 2014 Mirasvit (http://mirasvit.com/)
 */


$installer = $this;

$installer->startSetup();
$installer->run("
    DROP TABLE IF EXISTS `{$installer->getTable('emailreport/open')}`;
    CREATE TABLE `{$installer->getTable('emailreport/open')}` (
        `open_id`                 int(11)      NOT NULL AUTO_INCREMENT,
        `queue_id`                int(11)      NOT NULL,

        `remote_addr`             bigint(20)   NULL,

        `created_at`              datetime     NOT NULL DEFAULT '0000-00-00 00:00:00',
        `updated_at`              datetime     NOT NULL DEFAULT '0000-00-00 00:00:00',
        PRIMARY KEY (`open_id`)
    ) ENGINE=InnoDb DEFAULT CHARSET=utf8;

   DROP TABLE IF EXISTS `{$installer->getTable('emailreport/click')}`;
    CREATE TABLE `{$installer->getTable('emailreport/click')}` (
        `click_id`                int(11)      NOT NULL AUTO_INCREMENT,
        `queue_id`                int(11)      NOT NULL,
        
        `link`                    int(11)      NULL,
        `remote_addr`             bigint(20)   NULL,

        `created_at`              datetime     NOT NULL DEFAULT '0000-00-00 00:00:00',
        `updated_at`              datetime     NOT NULL DEFAULT '0000-00-00 00:00:00',
        PRIMARY KEY (`click_id`)
    ) ENGINE=InnoDb DEFAULT CHARSET=utf8;
");

$installer->endSetup();
