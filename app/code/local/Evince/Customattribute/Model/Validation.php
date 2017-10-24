<?php
/**
* @author Evince Team
* @package Evince_Customattribute
*/  
class Evince_Customattribute_Model_Validation
{
    /**
     * Retrieve additional validation types
     * 
     * @return array
     */
    public function getAdditionalValidation()
    {
        $addon = array();
        $path = str_replace('.php', '', __FILE__);
        $files = scandir($path);
        foreach ($files as $file) {
            if (false !== strpos($file, '.php')) {
                $addon[] = Mage::getModel('customattribute/validation_'.str_replace('.php', '', $file))->getValues();
            }
        }
        return $addon;
    }
     
    /**
     * Retrieve JS code
     *
     * @return string
     */
    public function getJS()
    {
        $js = '';
        $path = str_replace('.php', '', __FILE__);
        $files = scandir($path);
        foreach ($files as $file) {
            if (false !== strpos($file, '.php')) {
                $js .= Mage::getModel('customattribute/validation_'.str_replace('.php', '', $file))->getJS();
            }
        }
        return $js;
    }
}
