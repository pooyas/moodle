<?php


/**
 * Hidden type form element
 *
 * Contains HTML class for a hidden type element
 *
 * @package   core
 * @copyright 2015 Pooya Saeedi
 * 
 */

require_once('HTML/QuickForm/hidden.php');

/**
 * Hidden type form element
 *
 * HTML class for a hidden type element
 *
 */
class LionQuickForm_hidden extends HTML_QuickForm_hidden{
    /** @var string html for help button, if empty then no help */
    var $_helpbutton='';

    /**
     * Constructor
     *
     * @param string $elementName (optional) name of the hidden element
     * @param string $value (optional) value of the element
     * @param mixed  $attributes (optional) Either a typical HTML attribute string
     *               or an associative array
     */
    function LionQuickForm_hidden($elementName=null, $value='', $attributes=null) {
        parent::HTML_QuickForm_hidden($elementName, $value, $attributes);
    }

    /**
     * @deprecated since Lion 2.0
     */
    function setHelpButton($helpbuttonargs, $function='helpbutton'){
        throw new coding_exception('setHelpButton() can not be used any more, please see LionQuickForm::addHelpButton().');
    }

    /**
     * get html for help button
     *
     * @return string html for help button
     */
    function getHelpButton(){
        return '';
    }
}
