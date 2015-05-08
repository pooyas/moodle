<?php


/**
 * Button form element
 *
 * Contains HTML class for a button type element
 *
 * @package   core
 * @copyright 2015 Pooya Saeedi
 * 
 */

require_once("HTML/QuickForm/button.php");

/**
 * HTML class for a button type element
 *
 * Overloaded {@link HTML_QuickForm_button} to add help button
 *
 */
class LionQuickForm_button extends HTML_QuickForm_button
{
    /** @var string html for help button, if empty then no help */
    var $_helpbutton='';

    /**
     * constructor
     *
     * @param string $elementName (optional) name for the button
     * @param string $value (optional) value for the button
     * @param mixed $attributes (optional) Either a typical HTML attribute string
     *              or an associative array
     */
    function LionQuickForm_button($elementName=null, $value=null, $attributes=null) {
        parent::HTML_QuickForm_button($elementName, $value, $attributes);
    }

    /**
     * get html for help button
     *
     * @return string html for help button
     */
    function getHelpButton(){
        return $this->_helpbutton;
    }

    /**
     * Slightly different container template when frozen.
     *
     * @return string
     */
    function getElementTemplateType(){
        if ($this->_flagFrozen){
            return 'nodisplay';
        } else {
            return 'default';
        }
    }
}
