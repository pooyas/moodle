<?php



/**
 * url type form element
 *
 * Contains HTML class for a url type element
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

require_once("HTML/QuickForm/text.php");

/**
 * url type form element
 *
 * HTML class for a url type element
 * @category  form
 */
class LionQuickForm_url extends HTML_QuickForm_text{
    /** @var string html for help button, if empty then no help */
    var $_helpbutton='';

    /** @var bool if true label will be hidden */
    var $_hiddenLabel=false;

    /**
     * Constructor
     *
     * @param string $elementName Element name
     * @param mixed $elementLabel Label(s) for an element
     * @param mixed $attributes Either a typical HTML attribute string or an associative array.
     * @param array $options data which need to be posted.
     */
    function LionQuickForm_url($elementName=null, $elementLabel=null, $attributes=null, $options=null) {
        global $CFG;
        require_once("$CFG->dirroot/repository/lib.php");
        $options = (array)$options;
        foreach ($options as $name=>$value) {
            $this->_options[$name] = $value;
        }
        if (!isset($this->_options['usefilepicker'])) {
            $this->_options['usefilepicker'] = true;
        }
        parent::HTML_QuickForm_text($elementName, $elementLabel, $attributes);
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
        global $PAGE, $OUTPUT;

        $id     = $this->_attributes['id'];
        $elname = $this->_attributes['name'];

        if ($this->_hiddenLabel) {
            $this->_generateId();
            $str = '<label class="accesshide" for="'.$this->getAttribute('id').'" >'.
                        $this->getLabel().'</label>'.parent::toHtml();
        } else {
            $str = parent::toHtml();
        }
        if (empty($this->_options['usefilepicker'])) {
            return $str;
        }

        $client_id = uniqid();

        $args = new stdClass();
        $args->accepted_types = '*';
        $args->return_types = FILE_EXTERNAL;
        $args->context = $PAGE->context;
        $args->client_id = $client_id;
        $args->env = 'url';
        $fp = new file_picker($args);
        $options = $fp->options;

        if (count($options->repositories) > 0) {
            $straddlink = get_string('choosealink', 'repository');
            $str .= <<<EOD
<button id="filepicker-button-{$client_id}" class="visibleifjs">
$straddlink
</button>
EOD;
        }

        // print out file picker
        $str .= $OUTPUT->render($fp);

        $module = array('name'=>'form_url', 'fullpath'=>'/lib/form/url.js', 'requires'=>array('core_filepicker'));
        $PAGE->requires->js_init_call('M.form_url.init', array($options), true, $module);

        return $str;
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
     * Slightly different container template when frozen. Don't want to use a label tag
     * with a for attribute in that case for the element label but instead use a div.
     * Templates are defined in renderer constructor.
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
