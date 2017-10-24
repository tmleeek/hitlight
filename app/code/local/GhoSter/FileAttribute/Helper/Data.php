<?php

/**
 * GhoSter FileAttribute Helper
 *
 * @category    GhoSter
 * @package     GhoSter_FileAttribute
 * @author      opensource
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class GhoSter_FileAttribute_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Change file input display output to a download link
     *
     * @param  Mage_Catalog_Helper_Output $outputHelper
     * @param  string $outputHtml
     * @param  array $params
     * @return string
     */
    public function productAttribute(Mage_Catalog_Helper_Output $outputHelper, $outputHtml, $params)
    {
        /** @var $product Mage_Catalog_Model_Product */
        $product = $params['product'];

        $attribute = Mage::getModel('eav/entity_attribute')->loadByCode(Mage_Catalog_Model_Product::ENTITY, $params['attribute']);

        if ($attribute && ($attribute->getFrontendInput() == 'ghoster_file') && ($attributeValue = $product->getData($params['attribute']))) {
            $outputHtml = sprintf('<a href="%s" download>%s</a>', $this->escapeUrl(Mage::getBaseUrl('media') . 'catalog/product' . $attributeValue), Mage::helper('ghoster_fileattribute')->__('Download'));
        }

        return $outputHtml;
    }
}
