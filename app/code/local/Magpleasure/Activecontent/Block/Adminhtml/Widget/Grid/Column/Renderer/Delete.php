<?php
/**
 * MagPleasure Ltd.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE-CE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magpleasure.com/LICENSE-CE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento COMMUNITY edition
 * MagPleasure does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * Magpleasure does not provide extension support in case of
 * incorrect edition usage.
 * =================================================================
 *
 * @category   MagPleasure
 * @package    Magpleasure_Activecontent
 * @version    1.1.3
 * @copyright  Copyright (c) 2011-2014 MagPleasure Ltd. (http://www.magpleasure.com)
 * @license    http://www.magpleasure.com/LICENSE-CE.txt
 */

class Magpleasure_Activecontent_Block_Adminhtml_Widget_Grid_Column_Renderer_Delete
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    /**
     * Renders grid column
     *
     * @param   Varien_Object $row
     * @return  string
     */
    public function render(Varien_Object $row)
    {
        $html = "";
        if ($slideId = $this->_getValue($row)){

            $deleteUrl = $this->getUrl('*/admin_slide/delete', array(
                'id' => $this->getRequest()->getParam('id'),
                'slide_id' => $slideId,
            ));

            $confirmation = $this->__("Are you sure?");
            /** @var $button Mage_Adminhtml_Block_Widget_Button */
            $button = $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                'label'     => $this->__('Delete Slide'),
                'title'     => $this->__('Delete Slide'),
                'onclick'   => "if (confirm('{$confirmation}')) { setLocation('{$deleteUrl}'); } disabledEventPropagation(event);",
                'style'     => 'margin-left: 10px;',
                'class'     => 'scalable delete delete-select-row icon-btn',
            ));

            $html .= $button->toHtml();

        }
        return $html;
    }



}
