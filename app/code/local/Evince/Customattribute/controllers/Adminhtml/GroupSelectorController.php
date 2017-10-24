<?php
/**
* @author Evince Team
* @copyright Evince
* @package Evince_Customattribute
*/
class Evince_Customattribute_Adminhtml_GroupSelectorController extends Mage_Adminhtml_Controller_Action
{
    public function getGroupDataAction()
    {
        $param = Mage::app()->getRequest()->getParam('param');
        if (!$param) {
            $this->getResponse()->setBody('');
        } else {
            $groupValues = Mage::getResourceModel('customer/group_collection')
                ->setRealGroupsFilter()
                ->load()
                ->toOptionArray();
            
            foreach($groupValues as $key=>$val) {
                $response[$val['value']] = $val['label'];
            }
            
            $result = Zend_Json::encode($response);
            $this->getResponse()->setBody(
                $result
            );
        }
    }
}