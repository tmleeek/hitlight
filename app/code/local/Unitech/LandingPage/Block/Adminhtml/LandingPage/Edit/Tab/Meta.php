<?php
/**
 * Unitech Corp.
 *
 * @category   Unitech
 * @package    Unitech_LandingPage
 * @version    0.0.1
 * @copyright  @copyright Copyright (c) 2015 Unitech Corp. (http://www.unitech.vn)
 */

class Unitech_LandingPage_Block_Adminhtml_LandingPage_Edit_Tab_Meta extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('unitech_landingpage')->__('Meta Information');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * Returns status flag about this tab can be showen or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Set form id prefix, set values if landing page is editing
     *
     * @return Unitech_LandingPage_Block_Adminhtml_LandingPage_Edit_Tab_Meta
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $htmlIdPrefix = 'landingpage_meta_';
        $form->setHtmlIdPrefix($htmlIdPrefix);

        $fieldsetHtmlClass = 'fieldset-wide';

        $model = Mage::registry('current_landingpage');

        Mage::dispatchEvent(
            'adminhtml_landingpage_edit_tab_meta_before_prepare_form',
            array('model' => $model, 'form' => $form)
        );

        // add meta information fieldset
        $fieldset = $form->addFieldset(
            'default_fieldset', 
            array(
                'legend' => Mage::helper('unitech_landingpage')->__('Meta Information'),
                'class'  => $fieldsetHtmlClass,
            )
        );

        $fieldset->addField(
            'meta_keywords', 
            'textarea', 
            array(
                'name'     => 'meta_keywords',
                'label'    => Mage::helper('unitech_landingpage')->__('Meta Keywords'),
                'disabled' => (bool)$model->getIsReadonly(),
            )
        );

        $fieldset->addField(
            'meta_description', 
            'textarea', 
            array(
                'name'     => 'meta_description',
                'label'    => Mage::helper('unitech_landingpage')->__('Meta Description'),
                'disabled' => (bool)$model->getIsReadonly(),
            )
        );

       $form->setValues($model->getData());
       $this->setForm($form);
       return parent::_prepareForm();
    }
}