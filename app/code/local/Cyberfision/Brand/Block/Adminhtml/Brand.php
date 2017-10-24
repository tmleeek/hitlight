<?php
class Cyberfision_Brand_Block_Adminhtml_Brand extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected  function _construct()
    {
        parent::_construct();
        $this->_blockGroup = 'cyberfision_brand_adminhtml';
        $this->_controller = 'brand';
        $this->_headerText = Mage::helper('cyberfision_brand')->__('Buying guide manage');
    }

    public  function getCreateUrl()
    {
        return $this->getUrl('cyberfision_brand_admin/brand/edit');
    }
}
?>