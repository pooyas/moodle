<?php



/**
 * radio type form element
 *
 * Contains HTML class for a radio type element
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

require_once('HTML/QuickForm/radio.php');

/**
 * radio type form element
 *
 * HTML class for a radio type element
 *
 * @category  form
 */
class LionQuickForm_radio extends HTML_QuickForm_radio{
    /** @var string html for help button, if empty then no help */
    var $_helpbutton='';

    /**
     * constructor
     *
     * @param string $elementName (optional) name of the radio element
     * @param string $elementLabel (optional) label for radio element
     * @param string $text (optional) Text to put after the radio element
     * @param string $value (optional) default value
     * @param mixed $attributes (optional) Either a typical HTML attribute string
     *              or an associative array
     */
    function LionQuickForm_radio($elementName=null, $elementLabel=null, $text=null, $value=null, $attributes=null) {
        parent::HTML_QuickForm_radio($elementName, $elementLabel, $text, $value, $attributes);
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
            return 'static';
        } else {
            return 'default';
        }
    }

    /**
     * Returns the disabled field. Accessibility: the return "( )" from parent
     * class is not acceptable for screenreader users, and we DO want a label.
     *
     * @return string
     */
    function getFrozenHtml()
    {
        $output = '<input type="radio" disabled="disabled" id="'.$this->getAttribute('id').'" ';
        if ($this->getChecked()) {
            $output .= 'checked="checked" />'.$this->_getPersistantData();
        } else {
            $output .= '/>';
        }
        return $output;
    }

    /**
     * Returns HTML for advchecbox form element.
     *
     * @return string
     */
    function toHtml()
    {
        return '<span>' . parent::toHtml() . '</span>';
    }
}
