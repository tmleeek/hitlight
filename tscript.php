<?php
ini_set('display_errors', 1);
require_once 'app/Mage.php';
Mage::app();

$resource = Mage::getSingleton('core/resource');
$read = $resource->getConnection('core_read');
$write = $resource->getConnection('core_write');

$sql = "
select 

catalog_product_entity_int.entity_id as productid,
catalog_product_entity_int.value as typeCatalog

from catalog_product_entity_int

left join catalog_product_entity

on  catalog_product_entity_int.entity_id = catalog_product_entity.entity_id

where 
catalog_product_entity_int.entity_type_id = 4
and
catalog_product_entity_int.attribute_id = 95
and
catalog_product_entity_int.store_id = 0
and
catalog_product_entity.entity_type_id = 4
and
catalog_product_entity.type_id LIKE  'simple'

";
$sqlQuery = $read->fetchAll($sql);
echo 'All items: '. count($sqlQuery) . '<br>';
if ( count($sqlQuery) ) {
    $data = array("value" => "3");
    $attibuteId = 95; // catalog type
    $count = 0;
    foreach ($sqlQuery as $product) {
        //var_dump($product);
        // check typeCatalog = 1 => update to 3
        if ($product['typeCatalog'] == 1) {
            $count++;
            //echo $product['productid'].'<hr>';
            $where = "entity_id = '". $product['productid'] ."' and attribute_id = '". $attibuteId ."' ";
            $write->update("catalog_product_entity_int", $data, $where);
        }
    }
}

echo 'Have '.$count .' items simple product update.';

die;
?>