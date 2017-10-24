<?php
$installer = $this;
$installer->startSetup();

$installer->run("
    DROP TABLE IF EXISTS {$this->getTable('hil_downloader')};
    CREATE TABLE {$installer->getTable('hil_downloader')}(
    `id` int not null auto_increment,
    `customer_id` int,
    `customer_name` varchar(200),
    `customer_email` varchar(200),
    `customer_group_id` int,
    `create_at` datetime NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Hil Downloader';
");

$installer->endSetup();