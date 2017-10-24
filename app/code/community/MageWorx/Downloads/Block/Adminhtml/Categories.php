<?php
/**
 * MageWorx
 * File Downloads & Product Attachments Extension
 *
 * @category   MageWorx
 * @package    MageWorx_Downloads
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_Downloads_Block_Adminhtml_Categories extends MageWorx_Downloads_Block_Adminhtml_Abstract
{
    protected function _prepareLayout()
    {
        $this->setChild('add_new_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'   => Mage::helper('mageworx_downloads')->__('Add Category'),
                    'onclick' => "setLocation('" . $this->getUrl('*/*/new', array('store' => $this->getStoreId())) . "')",
                    'class'   => 'add'
                    ))
        );
        $this->setChild('grid', $this->getLayout()->createBlock('mageworx_downloads/adminhtml_categories_grid', 'categories.grid'));
        return parent::_prepareLayout();
    }

    public function getAddNewButtonHtml()
    {
        return $this->getChildHtml('add_new_button');
    }

    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }
}