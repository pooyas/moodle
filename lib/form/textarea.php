<?php



/**
 * Textarea type form element
 *
 * Contains HTML class for a textarea type element
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

require_once('HTML/QuickForm/textarea.php');

/**
 * Textarea type form element
 *
 * HTML class for a textarea type element
 *
 * @category  form
 */
class LionQuickForm_textarea extends HTML_QuickForm_textarea{
    /** @var string Need to store id of form as we may need it for helpbutton */
    var $_formid = '';

    /** @var string html for help button, if empty then no help */
    var $_helpbutton='';

    /** @var bool if true label will be hidden */
    var $_hiddenLabel=false;

    /**
     * constructor
     *
     * @param string $elementName (optional) name of the text field
     * @param string $elementLabel (optional) text field label
     * @param string $attributes (optional) Either a typical HTML attribute string or an associative array
     */
    function LionQuickForm_textarea($elementName=null, $elementLabel=null, $attributes=null) {
        parent::HTML_QuickForm_textarea($elementName, $elementLabel, $attributes);
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
     * Sets label to be hidden
     *
     * @param bool $hiddenLabel sets if label should be hidden
     */
    function setHiddenLabel($hiddenLabel){
        $this->_hiddenLabel = $hiddenLabel;
    }

    /**
     * Returns HTML for this form element.
     *
     * @return string
     */
    function toHtml(){
        if ($this->_hiddenLabel){
            $this->_generateId();
            return '<label class="accesshide" for="' . $this->getAttribute('id') . '" >' .
                    $this->getLabel() . '</label>' . parent::toHtml();
        } else {
            return parent::toHtml();
        }
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
                $this->_formid = $caller->getAttribute('id');
                break;
        }
        return parent::onQuickFormEvent($event, $arg, $caller);
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
}
