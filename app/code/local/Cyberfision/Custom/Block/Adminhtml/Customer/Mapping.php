<?php
class Cyberfision_Custom_Block_Adminhtml_Customer_Mapping extends Mage_Core_Block_Template
{
    public function getOptions(){
        $html = '<optgroup label="1 Customer" style="padding-left:12px;">';
        $html .= '<option value="customer:name">Name</option>';
        $html .= '<option value="customer:email">Email</option>';
        $html .= '<option value="customer:group">Group</option>';
        $html .= '<option value="customer:password">Password</option>';
        $html .= '</optgroup>';

        $html .= '<optgroup label="2 Billing Address" style="padding-left:12px;">';
        $html .= '<option value="billing:street1">Address 1</option>';
        $html .= '<option value="billing:street2">Address 2</option>';
        $html .= '<option value="billing:city">City</option>';
        $html .= '<option value="billing:region">State/Province</option>';
        $html .= '<option value="billing:postcode">Postcode/Zip</option>';
        $html .= '<option value="billing:telephone">Telephone</option>';
        $html .= '</optgroup>';

        $html .= '<optgroup label="3 Shipping Address" style="padding-left:12px;">';
        $html .= '<option value="shipping:street1">Address 1</option>';
        $html .= '<option value="shipping:street2">Address 2</option>';
        $html .= '<option value="shipping:city">City</option>';
        $html .= '<option value="shipping:region">State/Province</option>';
        $html .= '<option value="shipping:postcode">Postcode/Zip</option>';
        $html .= '<option value="shipping:telephone">Telephone</option>';
        $html .= '</optgroup>';

        return $html;
    }
}