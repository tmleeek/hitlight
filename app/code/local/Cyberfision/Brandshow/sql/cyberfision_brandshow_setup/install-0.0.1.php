<?php
$this->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'brand_id', array(
    'group'         => 'General',
    'label'         => 'Brand',
    'input'         => 'select',
    'source'        => 'cyberfision_brandshow/source_brand',
));