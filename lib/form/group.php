<?php


/**
 * Form element group
 *
 * Contains HTML class for group form element
 *
 * @package   core
 * @copyright 2015 Pooya Saeedi
 * 
 */

require_once("HTML/QuickForm/group.php");

/**
 * HTML class for a form element group
 *
 * Overloaded {@link HTML_QuickForm_group} with default behavior modified for Lion.
 *
 */
class LionQuickForm_group extends HTML_QuickForm_group{
    /** @var string html for help button, if empty then no help */
    var $_helpbutton='';

    /**
     * constructor
     *
     * @param string $elementName (optional) name of the group
     * @param string $elementLabel (optional) group label
     * @param array $elements (optional) array of HTML_QuickForm_element elements to group
     * @param string $separator (optional) string to seperate elements.
     * @param string $appendName (optional) string to appened to grouped elements.
     */
    function LionQuickForm_group($elementName=null, $elementLabel=null, $elements=null, $separator=null, $appendName = true) {
        parent::HTML_QuickForm_group($elementName, $elementLabel, $elements, $separator, $appendName);
    }

    /** @var string template type, would cause problems with client side validation so will leave for now */
    //var $_elementTemplateType='fieldset';

    /**
     * set html for help button
     */
    function getHelpButton(){
        return $this->_helpbutton;
    }

    /**
     * Returns element template, nodisplay/static/fieldset
     *
     * @return string
     */
    function getElementTemplateType(){
        if ($this->_flagFrozen){
            if ($this->getGroupType() == 'submit'){
                return 'nodisplay';
            } else {
                return 'static';
            }
        } else {
            if ($this->getGroupType() == 'submit') {
                return 'actionbuttons';
            }
            return 'fieldset';
        }
    }

    /**
     * Sets the grouped elements and hides label
     *
     * @param array $elements
     */
    function setElements($elements){
        parent::setElements($elements);
        foreach ($this->_elements as $element){
            if (method_exists($element, 'setHiddenLabel')){
                $element->setHiddenLabel(true);
            }
        }
    }
}
