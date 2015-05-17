<?php



/**
 * submit link type form element
 *
 * Contains HTML class for a submitting to link
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

global $CFG;
require_once("$CFG->libdir/form/submit.php");
/**
 * submit link type form element
 *
 * HTML class for a submitting to link
 *
 * @category  form
 */
class LionQuickForm_submitlink extends LionQuickForm_submit {
    /** @var string javascript for submitting element's data */
    var $_js;

    /** @var string callback function which will be called onclick event */
    var $_onclick;

    /**
     * constructor
     *
     * @param string $elementName (optional) name of the field
     * @param string $value (optional) field label
     * @param string $attributes (optional) Either a typical HTML attribute string or an associative array
     */
    function LionQuickForm_submitlink($elementName=null, $value=null, $attributes=null) {
        parent::LionQuickForm_submit($elementName, $value, $attributes);
    }

    /**
     * Returns HTML for submitlink form element.
     *
     * @return string
     */
    function toHtml() {
        $text = $this->_attributes['value'];
        $onmouseover = "window.status=\'" . $text . "\';";
        $onmouseout = "window.status=\'\';";

        return "<noscript><div>" . parent::toHtml() . '</div></noscript><script type="text/javascript">' . $this->_js . "\n"
             . 'document.write(\'<a href="#" onclick="' . $this->_onclick . '" onmouseover="' . $onmouseover . '" onmouseout="' . $onmouseout . '">'
             . $text . "</a>');\n</script>";
    }
}
