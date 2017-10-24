<?php
$installer = $this;
$installer->startSetup();

$installer->getConnection()
    ->addColumn($installer->getTable('cyberfision_brand/brand'),'banner', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable'  => false,
        'length'    => 255,
        'after'     => null, 
        'comment'   => 'Banner'
    ));
$installer->endSetup();

?>