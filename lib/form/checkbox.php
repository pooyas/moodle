<?php


/**
 * checkbox form element
 *
 * Contains HTML class for a checkbox type element
 *
 * @package   core
 * @copyright 2015 Pooya Saeedi
 * 
 */

require_once('HTML/QuickForm/checkbox.php');

/**
 * HTML class for a checkbox type element
 *
 * Overloaded {@link HTML_QuickForm_checkbox} to add help button. Also, fixes bug in quickforms
 * checkbox, which lets previous set value override submitted value if checkbox is not checked
 * and no value is submitted
 *
 */
class LionQuickForm_checkbox extends HTML_QuickForm_checkbox{
    /** @var string html for help button, if empty then no help */
    var $_helpbutton='';

    /**
     * Constructor
     *
     * @param string $elementName (optional) name of the checkbox
     * @param string $elementLabel (optional) checkbox label
     * @param string $text (optional) Text to put after the checkbox
     * @param mixed $attributes (optional) Either a typical HTML attribute string
     *              or an associative array
     */
    function LionQuickForm_checkbox($elementName=null, $elementLabel=null, $text='', $attributes=null) {
        parent::HTML_QuickForm_checkbox($elementName, $elementLabel, $text, $attributes);
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
     * Called by HTML_QuickForm whenever form event is made on this element
     *
     * @param string $event Name of event
     * @param mixed $arg event arguments
     * @param object $caller calling object
     * @return bool
     */
    function onQuickFormEvent($event, $arg, &$caller)
    {
        //fixes bug in quickforms which lets previous set value override submitted value if checkbox is not checked
        // and no value is submitted
        switch ($event) {
            case 'updateValue':
                // constant values override both default and submitted ones
                // default values are overriden by submitted
                $value = $this->_findValue($caller->_constantValues);
                if (null === $value) {
                    // if no boxes were checked, then there is no value in the array
                    // yet we don't want to display default value in this case
                    if ($caller->isSubmitted()) {
                        $value = $this->_findValue($caller->_submitValues);
                    } else {

                        $value = $this->_findValue($caller->_defaultValues);
                    }
                }
                //fix here. setChecked should not be conditional
                $this->setChecked($value);
                break;
            default:
                parent::onQuickFormEvent($event, $arg, $caller);
        }
        return true;
    }

    /**
     * Returns HTML for checbox form element.
     *
     * @return string
     */
    function toHtml()
    {
        return '<span>' . parent::toHtml() . '</span>';
    }

    /**
     * Returns the disabled field. Accessibility: the return "[ ]" from parent
     * class is not acceptable for screenreader users, and we DO want a label.
     *
     * @return string
     */
    function getFrozenHtml()
    {
        //$this->_generateId();
        $output = '<input type="checkbox" disabled="disabled" id="'.$this->getAttribute('id').'" ';
        if ($this->getChecked()) {
            $output .= 'checked="checked" />'.$this->_getPersistantData();
        } else {
            $output .= '/>';
        }
        return $output;
    }
}
