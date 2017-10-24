<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 7/1/16
 * Time: 3:01 PM
 */
class GhoSter_ShopByProject_Block_Adminhtml_Project_Edit_Tabs_Project extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {

        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('project_form', array('legend' => Mage::helper('ghoster_shopbyproject')->__('Project Information')));

        $project = Mage::registry('current_project');

        $validateClass = sprintf('required-entry validate-length maximum-length-%d',
            GhoSter_ShopByProject_Model_Project::PROJECT_TITLE_MAX_LENGTH);

        $fieldset->addField('title', 'text',
            array(
                'name' => 'title',
                'label' => Mage::helper('ghoster_shopbyproject')->__('Project Title'),
                'title' => Mage::helper('ghoster_shopbyproject')->__('Project Title'),
                'note' => Mage::helper('ghoster_shopbyproject')->__('Maximum length must be less then %s symbols', GhoSter_ShopByProject_Model_Project::PROJECT_TITLE_MAX_LENGTH),
                'class' => $validateClass,
                'required' => true,
            )
        );


        $project_image = $fieldset->addField('project_image', 'text',
            array(
                'name' => 'project_image',
                'label' => Mage::helper('ghoster_shopbyproject')->__('Project Image'),
                'class' => 'project_image',
                'title' => Mage::helper('ghoster_shopbyproject')->__('Project Image'),
            )
        );


        $form->getElement('project_image')->setRenderer(
            $this->getLayout()->createBlock('ghoster_shopbyproject/adminhtml_widget_form_element_browser', 'image_uploader', array(
                'element' => $project_image
            ))
        );


        $categories = Mage::getModel('ghoster_shopbyproject/categories');

        $category = $fieldset->addField('categories', 'multiselect', array(
            'label' => Mage::helper('ghoster_shopbyproject')->__('Select Categories'),
            'class' => 'required-entry categories',
            'required' => true,
            'name' => 'categories',
            'values' => $categories->toOptionArray(),
            'onchange' => 'getCategoriesTab(this)',
        ));

        $category->setAfterElementHtml("<script type=\"text/javascript\">
            function getCategoriesTab(selectElement){
                var result = [];
                var options = selectElement && selectElement.options;
                var opt;
                for (var i=0, iLen=options.length; i<iLen; i++) {
                    opt = options[i];
                
                    if (opt.selected) {
                      result.push(opt.value || opt.text);
                    }
                }
                
                var reloadUrl = '" . $this->getUrl('admin_shopbyproject/adminhtml_ajax/getCategoriesTab') . "ids/' + result + '/project_id/" . $project->getId() . "';
                new Ajax.Request(reloadUrl, {
                    type: 'post',
                    beforeSend: function () {
                    },
                    onSuccess: function(response) {
                        var json = response.responseText.evalJSON(true);
                        document.getElementById('project_tabs_common_product_content').innerHTML = json.common_products;
                        document.getElementById('project_tabs_slide_content').innerHTML = json.slides;
                        document.getElementById('project_tabs_product_content').innerHTML = json.products;
                        document.getElementById('project_tabs_description_content').innerHTML = json.description;
                        if(json.slideScript!=''){
                            eval(json.slideScript);
                        }
                    }
                });
            }
            
        </script>");


        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('ghoster_shopbyproject')->__('Status'),
            'values' => array(
                array('value' => 1, 'label' => 'Enabled'),
                array('value' => 0, 'label' => 'Disabled'),

            ),

            'name' => 'status',
        ));

        if (Mage::getSingleton('adminhtml/session')->getProjectData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getProjectData());
            Mage::getSingleton('adminhtml/session')->setProjectData(null);
        } elseif (Mage::registry('current_project')) {
            $form->setValues(Mage::registry('current_project')->getData());
        }

        $this->setForm($form);
        return parent::_prepareForm();
    }
}
