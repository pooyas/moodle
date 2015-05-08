<?php


/**
 * Yes/No drop down type form element
 *
 * Contains HTML class for a simple yes/ no drop down element
 *
 * @package   core
 * @copyright 2015 Pooya Saeedi
 * 
 */

global $CFG;
require_once "$CFG->libdir/form/select.php";

/**
 * Yes/No drop down type form element
 *
 * HTML class for a simple yes/ no drop down element
 *
 */
class LionQuickForm_selectyesno extends LionQuickForm_select{
    /**
     * Class constructor
     *
     * @param string $elementName Select name attribute
     * @param mixed $elementLabel Label(s) for the select
     * @param mixed $attributes Either a typical HTML attribute string or an associative array
     * @param mixed $options ignored, not used.
     */
    function LionQuickForm_selectyesno($elementName=null, $elementLabel=null, $attributes=null, $options=null)
    {
        HTML_QuickForm_element::HTML_QuickForm_element($elementName, $elementLabel, $attributes, null);
        $this->_type = 'selectyesno';
        $this->_persistantFreeze = true;
    }

    /**
     * Called by HTML_QuickForm whenever form event is made on this element
     *
     * @param string $event Name of event
     * @param mixed $arg event arguments
     * @param object $caller calling object
     * @return mixed
     */
    function onQuickFormEvent($event, $arg, &$caller)
    {
        switch ($event) {
            case 'createElement':
                $choices=array();
                $choices[0] = get_string('no');
                $choices[1] = get_string('yes');
                $this->load($choices);
                break;
        }
        return parent::onQuickFormEvent($event, $arg, $caller);
    }

}
