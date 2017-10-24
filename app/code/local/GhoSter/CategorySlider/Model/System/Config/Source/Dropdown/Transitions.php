<?php

/**
 * Class GhoSter_CategorySlider_Model_System_Config_Source_Dropdown_Transitions
 */
class GhoSter_CategorySlider_Model_System_Config_Source_Dropdown_Transitions
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'fade', 'label' => 'Fade'),
            array('value' => 'horizontal', 'label' => 'Horizontal'),
            array('value' => 'vertical', 'label' => 'Vertical'),
            array('value' => 'kenburns', 'label' => 'Kenburns'),

        );
    }
}