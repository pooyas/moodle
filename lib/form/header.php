<?php


/**
 * Header form element
 *
 * Contains a pseudo-element used for adding headers to form
 *
 * @package   core_form
 * @copyright 2007 Jamie Pratt <me@jamiep.org>
 * 
 */

require_once 'HTML/QuickForm/header.php';

/**
 * Header form element
 *
 * A pseudo-element used for adding headers to form
 *
 * @package   core_form
 * @category  form
 * @copyright 2007 Jamie Pratt <me@jamiep.org>
 * 
 */
class LionQuickForm_header extends HTML_QuickForm_header
{
    /** @var string html for help button, if empty then no help */
    var $_helpbutton='';

    /**
     * constructor
     *
     * @param string $elementName name of the header element
     * @param string $text text displayed in header element
     */
    function LionQuickForm_header($elementName = null, $text = null) {
        parent::HTML_QuickForm_header($elementName, $text);
    }

   /**
    * Accepts a renderer
    *
    * @param HTML_QuickForm_Renderer $renderer a HTML_QuickForm_Renderer object
    */
    function accept(&$renderer, $required=false, $error=null)
    {
        $this->_text .= $this->getHelpButton();
        $renderer->renderHeader($this);
    }

    /**
     * get html for help button
     *
     * @return string html for help button
     */
    function getHelpButton(){
        return $this->_helpbutton;
    }
}