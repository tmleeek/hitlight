<?php
/**
 * MageWorx
 * File Downloads & Product Attachments Extension
 *
 * @category   MageWorx
 * @package    MageWorx_Downloads
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

$installer = $this;
$installer->startSetup();

// insert cms blocks to whitelist

$installer->getConnection()->insertMultiple(
    $installer->getTable('admin/permission_block'),
    array(
        array('block_name' => 'mageworx_downloads/link', 'is_allowed' => 1),
        array('block_name' => 'mageworx_downloads/category_link', 'is_allowed' => 1),
        array('block_name' => 'mageworx_downloads/product_link', 'is_allowed' => 1),
    )
);

$installer->endSetup();