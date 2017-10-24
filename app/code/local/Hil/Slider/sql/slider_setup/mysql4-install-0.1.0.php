<?php
$installer = $this;
$installer->startSetup();

$installer->run("
    DROP TABLE IF EXISTS {$this->getTable('hil_slider')};
    CREATE TABLE {$installer->getTable('hil_slider')}(
    `id` int not null auto_increment,
    `banner_image` varchar(200),
    `url_banner` varchar(200),
    `desc_banner` text,
    `url_ebook` varchar(200),
    `desc_ebook` text,
    `status` int,
    `create_at` datetime NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Hil Slider';
");
$installer->endSetup();