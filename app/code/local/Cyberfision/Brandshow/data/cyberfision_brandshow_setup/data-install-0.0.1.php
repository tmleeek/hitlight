<?php
$brand = Mage::getModel('cyberfision_brand/brand');

for ($i = 1; $i <= 2; $i++) {
    $brand->setData(array(
            'name'        => "Item Name {$i}",
            'description' => "<p>Item Description {$i}</p>"
        ))
        ->save();
}