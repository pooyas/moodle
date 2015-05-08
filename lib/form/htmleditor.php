<?php


/**
 * htmleditor type form element
 *
 * Contains HTML class for htmleditor type element
 *
 * @package   core
 * @copyright 2015 Pooya Saeedi
 * 
 */

global $CFG;
require_once("$CFG->libdir/form/textarea.php");

/**
 * htmleditor type form element
 *
 * HTML class for htmleditor type element
 *
 */
class LionQuickForm_htmleditor extends LionQuickForm_textarea{
    /** @var string defines the type of editor */
    var $_type;

    /** @var array default options for html editor, which can be overridden */
    var $_options=array('rows'=>10, 'cols'=>45, 'width'=>0,'height'=>0);

    /**
     * Constructor
     *
     * @param string $elementName (optional) name of the html editor
     * @param string $elementLabel (optional) editor label
     * @param array $options set of options to create html editor
     * @param array $attributes (optional) Either a typical HTML attribute string
     *              or an associative array
     */
    function LionQuickForm_htmleditor($elementName=null, $elementLabel=null, $options=array(), $attributes=null){
        parent::LionQuickForm_textarea($elementName, $elementLabel, $attributes);
        // set the options, do not bother setting bogus ones
        if (is_array($options)) {
            foreach ($options as $name => $value) {
                if (array_key_exists($name, $this->_options)) {
                    if (is_array($value) && is_array($this->_options[$name])) {
                        $this->_options[$name] = @array_merge($this->_options[$name], $value);
                    } else {
                        $this->_options[$name] = $value;
                    }
                }
            }
        }
        $this->_type='htmleditor';

        editors_head_setup();
    }

    /**
     * Returns the input field in HTML
     *
     * @return string
     */
    function toHtml(){
        if ($this->_flagFrozen) {
            return $this->getFrozenHtml();
        } else {
            return $this->_getTabs() .
                    print_textarea(true,
                                    $this->_options['rows'],
                                    $this->_options['cols'],
                                    $this->_options['width'],
                                    $this->_options['height'],
                                    $this->getName(),
                                    preg_replace("/(\r\n|\n|\r)/", '&#010;',$this->getValue()),
                                    0, // unused anymore
                                    true,
                                    $this->getAttribute('id'));
        }
    }

    /**
     * What to display when element is frozen.
     *
     * @return string
     */
    function getFrozenHtml()
    {
        $html = format_text($this->getValue());
        return $html . $this->_getPersistantData();
    }
}
