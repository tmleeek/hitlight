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

class Magpleasure_Activecontent_Model_Block_Easing extends Magpleasure_Activecontent_Model_Block_Abstract
{
    protected function _easings()
    {
        return array(
            'linear' => array(
                'label' => $this->_helper()->__("No Effect"),
                'timing_function' => 'cubic-bezier(0, 0, 1, 1)',
            ),
            'swing' => array(
                'label' => $this->_helper()->__("Swing"),
                'timing_function' => 'cubic-bezier(.02, .01, .47, 1)',
            ),
            'easeInQuad' => array(
                'label' => $this->_helper()->__("Ease In Quad"),
                'timing_function' => 'cubic-bezier(0.55, 0.085, 0.68, 0.53)',
            ),
            'easeOutQuad' => array(
                'label' => $this->_helper()->__("Ease Out Quad"),
                'timing_function' => 'cubic-bezier(0.25, 0.46, 0.45, 0.94)',
            ),
            'easeInOutElastic' => array(
                'label' => $this->_helper()->__("Ease In Out Elastic"),
                'timing_function' => false,
            ),
            'easeInBack' => array(
                'label' => $this->_helper()->__("Ease In Back"),
                'timing_function' => 'cubic-bezier(0.6, -0.28, 0.735, 0.045)',
            ),
            'easeInOutCirc' => array(
                'label' => $this->_helper()->__("Ease In Out Circ"),
                'timing_function' => 'cubic-bezier(0.785, 0.135, 0.15, 0.86)',
            ),
            'easeOutBounce' => array(
                'label' => $this->_helper()->__("Ease Out Bounce"),
                'timing_function' => false,
            ),
        );
    }

    public function getTimingFunctionByEasing($name)
    {
        foreach ($this->_easings() as $key => $data){

            if ($key == $name){
                return $data['timing_function'];
            }
        }

        return false;
    }

    public function getOptionArray()
    {
        $options = array();
        foreach ($this->_easings() as $key => $data){
            $options[$key] = $data['label'];
        }
        return $options;
    }


}