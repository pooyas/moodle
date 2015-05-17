<?php



/**
 * Text type form element
 *
 * Contains HTML class for a text type element
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

require_once("HTML/QuickForm/static.php");

/**
 * Text type element
 *
 * HTML class for a text type element
 *
 * @category  form
 */
class LionQuickForm_static extends HTML_QuickForm_static{
    /** @var string Form element type */
    var $_elementTemplateType='static';

    /** @var string html for help button, if empty then no help */
    var $_helpbutton='';

    /**
     * constructor
     *
     * @param string $elementName (optional) name of the text field
     * @param string $elementLabel (optional) text field label
     * @param string $text (optional) Text to put in text field
     */
    function LionQuickForm_static($elementName=null, $elementLabel=null, $text=null) {
        parent::HTML_QuickForm_static($elementName, $elementLabel, $text);
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
