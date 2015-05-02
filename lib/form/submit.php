<?php


/**
 * submit type form element
 *
 * Contains HTML class for a submit type element
 *
 * @package   core_form
 * @copyright 2006 Jamie Pratt <me@jamiep.org>
 * 
 */

require_once("HTML/QuickForm/submit.php");

/**
 * submit type form element
 *
 * HTML class for a submit type element
 *
 * @package   core_form
 * @category  form
 * @copyright 2006 Jamie Pratt <me@jamiep.org>
 * 
 */
class LionQuickForm_submit extends HTML_QuickForm_submit {
    /**
     * constructor
     *
     * @param string $elementName (optional) name of the field
     * @param string $value (optional) field label
     * @param string $attributes (optional) Either a typical HTML attribute string or an associative array
     */
    function LionQuickForm_submit($elementName=null, $value=null, $attributes=null) {
        parent::HTML_QuickForm_submit($elementName, $value, $attributes);
    }

    /**
     * Called by HTML_QuickForm whenever form event is made on this element
     *
     * @param string $event Name of event
     * @param mixed $arg event arguments
     * @param object $caller calling object
     */
    function onQuickFormEvent($event, $arg, &$caller)
    {
        switch ($event) {
            case 'createElement':
                parent::onQuickFormEvent($event, $arg, $caller);
                if ($caller->isNoSubmitButton($arg[0])){
                    //need this to bypass client validation
                    //for buttons that submit but do not process the
                    //whole form.
                    $onClick = $this->getAttribute('onclick');
                    $skip = 'skipClientValidation = true;';
                    $onClick = ($onClick !== null)?$skip.' '.$onClick:$skip;
                    $this->updateAttributes(array('onclick'=>$onClick));
                }
                return true;
                break;
        }
        return parent::onQuickFormEvent($event, $arg, $caller);

    }

    /**
     * Slightly different container template when frozen. Don't want to display a submit
     * button if the form is frozen.
     *
     * @return string
     */
    function getElementTemplateType(){
        if ($this->_flagFrozen){
            return 'nodisplay';
        } else {
            return 'actionbuttons';
        }
    }

    /**
     * Freeze the element so that only its value is returned
     */
    function freeze(){
        $this->_flagFrozen = true;
    }

}
