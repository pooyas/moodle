<?php


/**
 * Drop down form element to select visibility in an activity mod update form
 *
 * Contains HTML class for a drop down element to select visibility in an activity mod update form
 *
 * @package   core_form
 * @copyright 2006 Jamie Pratt <me@jamiep.org>
 * 
 */

global $CFG;
require_once "$CFG->libdir/form/select.php";

/**
 * Drop down form element to select visibility in an activity mod update form
 *
 * HTML class for a drop down element to select visibility in an activity mod update form
 *
 * @package   core_form
 * @category  form
 * @copyright 2006 Jamie Pratt <me@jamiep.org>
 * 
 */
class LionQuickForm_modvisible extends LionQuickForm_select{

    /**
     * Class constructor
     *
     * @param string $elementName Select name attribute
     * @param mixed $elementLabel Label(s) for the select
     * @param mixed $attributes Either a typical HTML attribute string or an associative array
     * @param array $options ignored
     */
    function LionQuickForm_modvisible($elementName=null, $elementLabel=null, $attributes=null, $options=null)
    {
        HTML_QuickForm_element::HTML_QuickForm_element($elementName, $elementLabel, $attributes, null);
        $this->_type = 'modvisible';


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
                $choices=array();
                $choices[1] = get_string('show');
                $choices[0] = get_string('hide');
                $this->load($choices);
                break;

        }
        return parent::onQuickFormEvent($event, $arg, $caller);
    }
}
