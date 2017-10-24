<?php


class GhoSter_CategorySlider_Block_Adminhtml_Widget_Form_Element_Browser
    extends GhoSter_Common_Block_Adminhtml_Widget_Form_Element_Browser
{

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('ghoster/categoryslider/widget/form/element/browser.phtml');
    }

    protected function _prepareLayout()
    {
        $browserBtn = $this->getLayout()->createBlock('adminhtml/widget_button', 'button', array(
            'label' => '...',
            'title' => Mage::helper('ghoster_categoryslider')->__('Click to browser media'),
            'type' => 'button',
            'onclick' => sprintf('GhoSter.MediabrowserUtility.openDialog(\'%s\')',
                Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg_images/index', array(
                    'static_urls_allowed' => 1,
                    'target_element_id' => $this->getElement()->getHtmlId()
                ))
            )
        ));
        $this->setChild('browserBtn', $browserBtn);
        $clearBtn = $this->getLayout()->createBlock('adminhtml/widget_button', 'button', array(
            'label' => 'x',
            'title' => Mage::helper('ghoster_categoryslider')->__('Click to clear value'),
            'type' => 'button',
            'onclick' => "on_{$this->getElement()->getHtmlId()}_clear_click();"
        ));
        $this->setChild('clearBtn', $clearBtn);

        return parent::_prepareLayout();
    }
}