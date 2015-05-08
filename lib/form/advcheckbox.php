<?php


/**
 * Advanced checkbox type form element
 *
 * Contains HTML class for an advcheckbox type form element
 *
 * @package   core
 * @copyright 2015 Pooya Saeedi
 * 
 */

require_once('HTML/QuickForm/advcheckbox.php');

/**
 * HTML class for an advcheckbox type element
 *
 * Overloaded {@link HTML_QuickForm_advcheckbox} with default behavior modified for Lion.
 * This will return '0' if not checked and '1' if checked.
 *
 * 
 */
class LionQuickForm_advcheckbox extends HTML_QuickForm_advcheckbox{
    /** @var string html for help button, if empty then no help will icon will be dispalyed. */
    var $_helpbutton='';

    /** @var string Group to which this checkbox belongs (for select all/select none button) */
    var $_group;

    /**
     * constructor
     *
     * @param string $elementName (optional) name of the checkbox
     * @param string $elementLabel (optional) checkbox label
     * @param string $text (optional) Text to put after the checkbox
     * @param mixed $attributes (optional) Either a typical HTML attribute string
     *              or an associative array
     * @param mixed $values (optional) Values to pass if checked or not checked
     */
    function LionQuickForm_advcheckbox($elementName=null, $elementLabel=null, $text=null, $attributes=null, $values=null)
    {
        if ($values === null){
            $values = array(0, 1);
        }

        if (!is_null($attributes['group'])) {

            $this->_group = 'checkboxgroup' . $attributes['group'];
            unset($attributes['group']);
            if (is_null($attributes)) {
                $attributes = array();
                $attributes['class'] .= " $this->_group";
            } elseif (is_array($attributes)) {
                if (isset($attributes['class'])) {
                    $attributes['class'] .= " $this->_group";
                } else {
                    $attributes['class'] = $this->_group;
                }
            } elseif ($strpos = stripos($attributes, 'class="')) {
                $attributes = str_ireplace('class="', 'class="' . $this->_group . ' ', $attributes);
            } else {
                $attributes .= ' class="' . $this->_group . '"';
            }
        }

        parent::HTML_QuickForm_advcheckbox($elementName, $elementLabel, $text, $attributes, $values);
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
     * Returns HTML for advchecbox form element.
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
