<?php



/**
 * static warning element
 *
 * Contains class for static warning type element
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */
require_once("HTML/QuickForm/static.php");

/**
 * static warning
 *
 * overrides {@link HTML_QuickForm_static} to display staic warning.
 *
 * @category  form
 */
class LionQuickForm_warning extends HTML_QuickForm_static{
    /** @var string Form element type */
    var $_elementTemplateType='warning';

    /** @var string html for help button, if empty then no help */
    var $_helpbutton='';

    /** @var string class assigned to field, default is notifyproblem */
    var $_class='';

    /**
     * constructor
     *
     * @param string $elementName (optional) name of the field
     * @param string $elementClass (optional) show as warning or notification => 'notifyproblem'
     * @param string $text (optional) Text to put in warning field
     */
    function LionQuickForm_warning($elementName=null, $elementClass='notifyproblem', $text=null) {
        parent::HTML_QuickForm_static($elementName, null, $text);
        $this->_type = 'warning';
        if (is_null($elementClass)) {
            $elementClass = 'notifyproblem';
        }
        $this->_class = $elementClass;
    }

    /**
     * Returns HTML for this form element.
     *
     * @return string
     */
    function toHtml() {
        global $OUTPUT;
        return $OUTPUT->notification($this->_text, $this->_class);
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
     * Gets the type of form element
     *
     * @return string
     */
    function getElementTemplateType(){
        return $this->_elementTemplateType;
    }
}
