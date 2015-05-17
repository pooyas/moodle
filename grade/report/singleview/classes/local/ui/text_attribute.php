<?php


/**
 * UI element for a text input field.
 *
 * @package    grade_report
 * @subpackage singleview
 * @copyright  2015 Pooya Saeedi
 */

namespace gradereport_singleview\local\ui;

use html_writer;
defined('LION_INTERNAL') || die;

/**
 * UI element for a text input field.
 *
 */
class text_attribute extends element {

    /** @var bool $isdisabled Is this input disabled? */
    private $isdisabled;

    /**
     * Constructor
     *
     * @param string $name The input name (the first bit)
     * @param string $value The input initial value.
     * @param string $label The label for this input field.
     * @param bool $isdisabled Is this input disabled.
     */
    public function __construct($name, $value, $label, $isdisabled = false) {
        $this->isdisabled = $isdisabled;
        parent::__construct($name, $value, $label);
    }

    /**
     * Nasty function allowing custom textbox behaviour outside the class.
     * @return bool Is this a textbox.
     */
    public function is_textbox() {
        return true;
    }

    /**
     * Render the html for this field.
     * @return string The HTML.
     */
    public function html() {
        $attributes = array(
            'type' => 'text',
            'name' => $this->name,
            'value' => $this->value,
            'id' => $this->name
        );

        if ($this->isdisabled) {
            $attributes['disabled'] = 'DISABLED';
        }

        $hidden = array(
            'type' => 'hidden',
            'name' => 'old' . $this->name,
            'value' => $this->value
        );

        $label = '';
        if (preg_match("/^feedback/", $this->name)) {
            $labeltitle = get_string('feedbackfor', 'gradereport_singleview', $this->label);
            $label = html_writer::tag('label', $labeltitle,  array('for' => $this->name, 'class' => 'accesshide'));
        } else if (preg_match("/^finalgrade/", $this->name)) {
            $labeltitle = get_string('gradefor', 'gradereport_singleview', $this->label);
            $label = html_writer::tag('label', $labeltitle,  array('for' => $this->name, 'class' => 'accesshide'));
        }

        return (
            $label .
            html_writer::empty_tag('input', $attributes) .
            html_writer::empty_tag('input', $hidden)
        );
    }
}
