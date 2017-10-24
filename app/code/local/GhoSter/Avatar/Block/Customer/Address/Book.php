<?php

class GhoSter_Avatar_Block_Customer_Address_Book extends Mage_Customer_Block_Address_Book
{
    protected function _beforeToHtml()
    {
        if (!$this->getTemplate()) {
            $this->setTemplate('ghoster/avatar/customer/address/book.phtml');
        }
        return parent::_beforeToHtml();
    }
}
