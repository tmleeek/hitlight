<?php
/**
* @author Evince Team
* @copyright Evince
* @package Evince_Customattribute
*/
class Evince_Customattribute_Block_Adminhtml_Customer_Relation_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'customattribute';
        $this->_objectId = 'attribute_id';
        $this->_controller = 'adminhtml_customer_relation';

		$this->_addButton('add_new_relation', array(
                'label'     => Mage::helper('customattribute')->__('New Relation'),
                'onclick'   => 'newRelation()',
                'class' => 'add'
            ), 0, 2);

		$this->_addButton('add_new_attribute', array(
                'label'     => Mage::helper('customattribute')->__('New Attribute'),
                'onclick'   => 'newAttribute()',
                'class' => 'add'
            ), 0, 1);
            
		$this->_updateButton('save', 'label', Mage::helper('customattribute')->__('Save Relation'), 0, 3);
		        
		$this->_formScripts[] = " function newAttribute(){ setLocation('" . $this->getUrl('*/adminhtml_manage/new'). "');} ";        
		$this->_formScripts[] = " function newRelation(){ setLocation('" . $this->getUrl('*/adminhtml_relation/new'). "');} ";
        
        $this->_formScripts[] = "
            function customattribute_load_attr_options()
            {
	            
            	new Ajax.Request('" . $this->getUrl('*/*/options', array('isAjax'=>true)) ."?attributeId=' + $('attribute_id').value, {
	                parameters: {
    				},
	                onSuccess: function(transport) {
						var data = transport.responseText;
						if(!data.isJSON()) {
							return; 
						}
						data = data.evalJSON();
							                
	                    $('option_id').update(data.options);
	                    $('dependend_attribute_id').update(data.dependent);
	                },
	                onFailure: function() {
	                	
	                }
	                
	            });
            }
            obj = document.getElementById('attribute_id');
            Event.observe(obj,'change', customattribute_load_attr_options);            
            
        ";
        
        parent::__construct();
        $this->_removeButton('reset');
    }

    public function getHeaderText()
    {
        if (Mage::registry('entity_relation')->getId()) {
            $frontendLabel = Mage::registry('entity_relation')->getName();
            if (is_array($frontendLabel)) {
                $frontendLabel = $frontendLabel[0];
            }
            return Mage::helper('catalog')->__('Edit Relation "%s"', $this->htmlEscape($frontendLabel));
        }
        else {
            return Mage::helper('catalog')->__('New Relation');
        }
    }

    public function getValidationUrl()
    {
        return $this->getUrl('*/*/validate', array('_current'=>true));
    }

    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save', array('_current'=>true, 'back'=>null));
    }
}
