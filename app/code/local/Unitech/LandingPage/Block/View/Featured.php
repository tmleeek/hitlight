<?php
/**
 * Unitech Corp.
 *
 * @category   Unitech
 * @package    Unitech_LandingPage
 * @version    0.0.1
 * @copyright  @copyright Copyright (c) 2015 Unitech Corp. (http://www.unitech.vn)
 */
class Unitech_LandingPage_Block_View_Featured extends Mage_Catalog_Block_Product_Abstract
{
    /**
     * Featured Product Collection
     *
     * @var Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection
     */
    protected $_featuredProductCollection;

    /**
     * Get target rule collection for related and up-sell
     *
     * @return array
     */
    protected function _getFeaturedProductCollection()
    {
        $landingPage = $this->getLandingPage();
        $skus = explode(',', $landingPage->getPartNumbers());
        if (is_null($this->_featuredProductCollection)) {
            /** @var $collection Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection */
            $this->_featuredProductCollection = Mage::getResourceModel('catalog/product_collection');
			$this->_featuredProductCollection->addFieldToFilter('sku', array('in' => $skus));
			$this->_addProductAttributesAndPrices($this->_featuredProductCollection);
			
            Mage::getSingleton('catalog/product_visibility')
                ->addVisibleInCatalogFilterToCollection($this->_featuredProductCollection);
				
			$orderExpr = "";
			for($i=0;$i<count($skus);$i++)
			{
				if($i==0)
				{
					$orderExpr .= "'".$skus[$i]. "'";
				}
				else
				{
					$orderExpr .= ",'" . $skus[$i] ."'";
				}
			}
   
			$this->_featuredProductCollection->getSelect()->order(new Zend_Db_Expr("FIELD(sku,".$orderExpr.")"));
   
            $this->_featuredProductCollection->setFlag('do_not_use_category_id', true);
        }
		
        return $this->_featuredProductCollection;
    }
    
    /**
     * Retrieve loaded featured product collection
     *
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection
     */
    public function getLoadedFeaturedProductCollection()
    {
        return $this->_getFeaturedProductCollection();
    }

    /**
     * Retrieve landing page instance
     *
     * @return Unitech_LandingPage_Model_LandingPage
     */
    public function getLandingPage()
    {
		$landingPageId = $this->getRequest()->getParam('landingpage_id', false);
        if (!Mage::registry('landingpage') && $landingPageId) {
            $landingPage = Mage::getModel('unitech_landingpage/landingPage')
                    ->setStoreId(Mage::app()->getStore()->getId())
                    ->load($landingPageId);
            Mage::register('landingpage', $landingPage);
        }
        return Mage::registry('landingpage');
    }
	
	public function getRatings()
    {
        $ratingCollection = Mage::getModel('rating/rating')
            ->getResourceCollection()
            ->addEntityFilter('product')
            ->setPositionOrder()
            ->addRatingPerStoreName(Mage::app()->getStore()->getId())
            ->setStoreFilter(Mage::app()->getStore()->getId())
            ->load()
            ->addOptionToItems();
        return $ratingCollection;
    }
	
	public function getAdditionalData($product)
    {
        $data = array();
        //$product = $this->getProduct();
        $attributes = $product->getAttributes();
        foreach ($attributes as $attribute) {
//            if ($attribute->getIsVisibleOnFront() && $attribute->getIsUserDefined() && !in_array($attribute->getAttributeCode(), $excludeAttr)) {
            if ($attribute->getIsVisibleOnFront() && !in_array($attribute->getAttributeCode(), $excludeAttr)) {
                $value = $attribute->getFrontend()->getValue($product);

                if (!$product->hasData($attribute->getAttributeCode())) {
                    $value = Mage::helper('catalog')->__('N/A');
                } elseif ((string)$value == '') {
                    $value = Mage::helper('catalog')->__('No');
                } elseif ($attribute->getFrontendInput() == 'price' && is_string($value)) {
                    $value = Mage::app()->getStore()->convertPrice($value, true);
                }

                if (is_string($value) && strlen($value)) {
                    $data[$attribute->getAttributeCode()] = array(
                        'label' => $attribute->getStoreLabel(),
                        'value' => $value,
                        'code'  => $attribute->getAttributeCode()
                    );
                }
            }
        }
        return $data;
    }
}