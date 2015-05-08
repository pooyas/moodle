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

if (!defined('LION_INTERNAL')) {
    die('Direct access to this script is forbidden.');    //  It must be included from a Lion page
}

global $CFG;
require_once($CFG->libdir.'/form/submit.php');

/**
 * HTML class for a submit cancel type element
 *
 * Overloaded {@link LionQuickForm_submit} with default behavior modified to cancel a form.
 *
 */
class LionQuickForm_cancel extends LionQuickForm_submit
{
    /**
     * constructor
     *
     * @param string $elementName (optional) name of the checkbox
     * @param string $value (optional) value for the button
     * @param mixed $attributes (optional) Either a typical HTML attribute string
     *              or an associative array
     */
    function LionQuickForm_cancel($elementName=null, $value=null, $attributes=null)
    {
        if ($elementName==null){
            $elementName='cancel';
        }
        if ($value==null){
            $value=get_string('cancel');
        }
        LionQuickForm_submit::LionQuickForm_submit($elementName, $value, $attributes);
        $this->updateAttributes(array('onclick'=>'skipClientValidation = true; return true;'));

        // Add the class btn-cancel.
        $class = $this->getAttribute('class');
        if (empty($class)) {
            $class = '';
        }
        $this->updateAttributes(array('class' => $class . ' btn-cancel'));
    }

    /**
     * Called by HTML_QuickForm whenever form event is made on this element
     *
     * @param string $event Name of event
     * @param mixed $arg event arguments
     * @param object $caller calling object
     * @return bool
     */
    function onQuickFormEvent($event, $arg, &$caller)
    {
        switch ($event) {
            case 'createElement':
                $className = get_class($this);
                $this->$className($arg[0], $arg[1], $arg[2]);
                $caller->_registerCancelButton($this->getName());
                return true;
                break;
        }
        return parent::onQuickFormEvent($event, $arg, $caller);
    }

    /**
     * Returns the value of field without HTML tags
     *
     * @return string
     */
    function getFrozenHtml(){
        return HTML_QuickForm_submit::getFrozenHtml();
    }

    /**
     * Freeze the element so that only its value is returned
     *
     * @return bool
     */
    function freeze(){
        return HTML_QuickForm_submit::freeze();
    }
}
